<?php
/**
 * REST API Endpoints
 *
 * @package FreshDewClinicSystem
 */

if (!defined('ABSPATH')) {
    exit;
}

class FDCS_REST_Endpoints {

    public function __construct() {
        add_action('rest_api_init', array($this, 'register_routes'));
    }

    public function register_routes() {
        $namespace = 'fdcs/v1';

        // Dashboard stats
        register_rest_route($namespace, '/stats', array(
            'methods'             => 'GET',
            'callback'            => array($this, 'get_stats'),
            'permission_callback' => function () {
                return current_user_can('fdcs_access_dashboard');
            },
        ));

        // Patients
        register_rest_route($namespace, '/patients', array(
            'methods'             => 'GET',
            'callback'            => array($this, 'get_patients'),
            'permission_callback' => function () {
                return current_user_can('fdcs_view_all_patients') || current_user_can('fdcs_view_own_patients');
            },
        ));

        register_rest_route($namespace, '/patients/(?P<id>\d+)', array(
            'methods'             => 'GET',
            'callback'            => array($this, 'get_patient'),
            'permission_callback' => function () {
                return current_user_can('fdcs_view_all_patients') || current_user_can('fdcs_view_own_patients');
            },
        ));

        // Appointments
        register_rest_route($namespace, '/appointments', array(
            'methods'             => 'GET',
            'callback'            => array($this, 'get_appointments'),
            'permission_callback' => function () {
                return current_user_can('fdcs_manage_appointments') || current_user_can('fdcs_manage_own_appointments') || current_user_can('fdcs_book_appointments');
            },
        ));

        register_rest_route($namespace, '/appointments', array(
            'methods'             => 'POST',
            'callback'            => array($this, 'create_appointment'),
            'permission_callback' => function () {
                return current_user_can('fdcs_manage_appointments') || current_user_can('fdcs_manage_own_appointments') || current_user_can('fdcs_book_appointments');
            },
        ));

        register_rest_route($namespace, '/appointments/(?P<id>\d+)/status', array(
            'methods'             => 'PUT',
            'callback'            => array($this, 'update_appointment_status'),
            'permission_callback' => function () {
                return current_user_can('fdcs_manage_appointments') || current_user_can('fdcs_manage_own_appointments');
            },
        ));

        // Audit log
        register_rest_route($namespace, '/audit-log', array(
            'methods'             => 'GET',
            'callback'            => array($this, 'get_audit_log'),
            'permission_callback' => function () {
                return current_user_can('fdcs_view_audit_log');
            },
        ));
    }

    /**
     * GET /stats — Dashboard overview statistics
     */
    public function get_stats($request) {
        $today = current_time('Y-m-d');

        $stats = array(
            'total_patients'      => FDCS_Patient::count(),
            'waitlist_patients'   => FDCS_Patient::count(array('status' => 'waitlist')),
            'active_patients'     => FDCS_Patient::count(array('status' => 'active')),
            'today_appointments'  => FDCS_Appointment::count(array('date' => $today)),
            'total_appointments'  => FDCS_Appointment::count(),
        );

        // Doctor-specific stats
        if (current_user_can('fdcs_manage_own_appointments') && !current_user_can('fdcs_manage_appointments')) {
            $doctor_id = get_current_user_id();
            $stats['my_patients'] = FDCS_Patient::count(array('doctor_id' => $doctor_id));
            $stats['my_today_appointments'] = FDCS_Appointment::count(array('date' => $today, 'doctor_id' => $doctor_id));
        }

        return rest_ensure_response($stats);
    }

    /**
     * GET /patients
     */
    public function get_patients($request) {
        $args = array(
            'status'  => $request->get_param('status') ?? '',
            'search'  => $request->get_param('search') ?? '',
            'limit'   => min(100, max(1, (int) ($request->get_param('limit') ?? 20))),
            'offset'  => max(0, (int) ($request->get_param('offset') ?? 0)),
        );

        // Doctors can only see their own patients
        if (current_user_can('fdcs_view_own_patients') && !current_user_can('fdcs_view_all_patients')) {
            $args['doctor_id'] = get_current_user_id();
        }

        $patients = FDCS_Patient::get_all($args);
        $total = FDCS_Patient::count($args);

        return rest_ensure_response(array(
            'patients' => $patients,
            'total'    => $total,
            'limit'    => $args['limit'],
            'offset'   => $args['offset'],
        ));
    }

    /**
     * GET /patients/:id
     */
    public function get_patient($request) {
        $patient = FDCS_Patient::get($request['id']);

        if (!$patient) {
            return new WP_Error('not_found', 'Patient not found', array('status' => 404));
        }

        // Doctors can only view their assigned patients
        if (current_user_can('fdcs_view_own_patients') && !current_user_can('fdcs_view_all_patients')) {
            if ((int) $patient->assigned_doctor_id !== get_current_user_id()) {
                return new WP_Error('forbidden', 'Not authorized to view this patient', array('status' => 403));
            }
        }

        // Add user info
        $user = get_userdata($patient->user_id);
        if ($user) {
            $patient->display_name = $user->display_name;
            $patient->email = $user->user_email;
            $patient->phone = get_user_meta($user->ID, 'phone', true);
        }

        return rest_ensure_response($patient);
    }

    /**
     * GET /appointments
     */
    public function get_appointments($request) {
        $date = $request->get_param('date') ?? current_time('Y-m-d');
        $doctor_id = 0;

        // Doctors see only their appointments
        if (current_user_can('fdcs_manage_own_appointments') && !current_user_can('fdcs_manage_appointments')) {
            $doctor_id = get_current_user_id();
        } elseif ($request->get_param('doctor_id')) {
            $doctor_id = (int) $request->get_param('doctor_id');
        }

        // Patients see only their appointments
        if (current_user_can('fdcs_book_appointments') && !current_user_can('fdcs_manage_appointments')) {
            $patient = FDCS_Patient::get_by_user_id(get_current_user_id());
            if ($patient) {
                $appointments = FDCS_Appointment::get_patient_upcoming($patient->id);
                return rest_ensure_response($appointments);
            }
            return rest_ensure_response(array());
        }

        $appointments = FDCS_Appointment::get_by_date($date, $doctor_id);
        return rest_ensure_response($appointments);
    }

    /**
     * POST /appointments
     */
    public function create_appointment($request) {
        $data = $request->get_json_params();

        $required = array('patient_id', 'doctor_id', 'appointment_date', 'appointment_time');
        foreach ($required as $field) {
            if (empty($data[$field])) {
                return new WP_Error('missing_field', "Field '$field' is required", array('status' => 400));
            }
        }

        $appointment_id = FDCS_Appointment::create($data);

        if (!$appointment_id) {
            return new WP_Error('create_failed', 'Failed to create appointment', array('status' => 500));
        }

        return rest_ensure_response(array(
            'id'      => $appointment_id,
            'message' => 'Appointment created successfully',
        ));
    }

    /**
     * PUT /appointments/:id/status
     */
    public function update_appointment_status($request) {
        $data = $request->get_json_params();
        $status = sanitize_text_field($data['status'] ?? '');

        if (empty($status)) {
            return new WP_Error('missing_status', 'Status is required', array('status' => 400));
        }

        $result = FDCS_Appointment::update_status($request['id'], $status);

        if ($result === false) {
            return new WP_Error('update_failed', 'Failed to update status', array('status' => 500));
        }

        return rest_ensure_response(array('message' => 'Status updated'));
    }

    /**
     * GET /audit-log
     */
    public function get_audit_log($request) {
        $limit = min(100, max(1, (int) ($request->get_param('limit') ?? 50)));
        $offset = max(0, (int) ($request->get_param('offset') ?? 0));

        $logs = FDCS_Audit_Log::get_recent($limit, $offset);
        $total = FDCS_Audit_Log::count();

        return rest_ensure_response(array(
            'logs'   => $logs,
            'total'  => $total,
            'limit'  => $limit,
            'offset' => $offset,
        ));
    }
}

new FDCS_REST_Endpoints();

