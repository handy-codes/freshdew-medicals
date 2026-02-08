<?php
/**
 * Template Name: About Page
 *
 * @package FreshDewMedical
 */

get_header();
$contact_info = freshdew_get_contact_info();
?>

<section style="padding: 4rem 0; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <h1 style="font-size: 3rem; margin-bottom: 1rem; text-align: center; color: white; text-shadow: 0 2px 10px rgba(0,0,0,0.2);">About FreshDew Medical Clinic</h1>
        <p style="font-size: 1.25rem; text-align: center; opacity: 0.95; max-width: 800px; margin: 0 auto; color: white; text-shadow: 0 1px 5px rgba(0,0,0,0.2);">
            Providing exceptional healthcare services to the Belleville community and surrounding areas.
        </p>
    </div>
</section>

<section style="padding: 4rem 0;">
    <div class="container">
        <div style="max-width: 1200px; margin: 0 auto;">
            <h2 style="font-size: 2.5rem; margin-bottom: 2rem; color: #1f2937;">Our Mission</h2>
            <p style="color: #4b5563; line-height: 1.8; margin-bottom: 1.5rem; font-size: 1.125rem;">
                FreshDew Medical Clinic is committed to delivering premium medical care with cutting-edge technology, 
                compassionate professionals, and innovative telehealth solutions. We believe that quality healthcare should 
                be accessible to all Canadians.
            </p>
            
            <!-- Meet Our Team Section -->
            <h2 style="font-size: 2.5rem; margin: 4rem 0 3rem; color: #1f2937; text-align: center;">Meet Our Team</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2.5rem; margin-bottom: 4rem;">
                
                <!-- Doctor 1 - Male -->
                <div style="background: white; border-radius: 0.75rem; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: transform 0.3s ease, box-shadow 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 12px rgba(0,0,0,0.15)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.1)';">
                    <div style="width: 100%; height: 300px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden;">
                        <?php
                        $doctor1_image = get_template_directory_uri() . '/assets/images/doctors/dr-michael-chen.jpg';
                        if (file_exists(get_template_directory() . '/assets/images/doctors/dr-michael-chen.jpg')) {
                            echo '<img src="' . esc_url($doctor1_image) . '" alt="Dr. Michael Chen" style="width: 200px; height: 200px; border-radius: 50%; object-fit: cover; border: 4px solid rgba(255,255,255,0.3);">';
                        } else {
                            echo '<div style="width: 200px; height: 200px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem; font-weight: 600;">MC</div>';
                        }
                        ?>
                    </div>
                    <div style="padding: 2rem;">
                        <h3 style="font-size: 1.5rem; font-weight: 700; color: #1f2937; margin-bottom: 0.5rem;">Dr. Michael Chen</h3>
                        <p style="color: #667eea; font-size: 0.875rem; font-weight: 600; margin-bottom: 1rem;">MD, CCFP, FRCPC</p>
                        <p style="color: #6b7280; line-height: 1.7; margin-bottom: 1.5rem; font-size: 0.95rem;">
                            Dr. Chen is a board-certified Family Physician with over 15 years of experience serving the Belleville community. 
                            He specializes in preventive care, chronic disease management, and men's health. Dr. Chen completed his medical 
                            degree at the University of Toronto and is committed to providing compassionate, patient-centered care.
                        </p>
                        <a href="<?php echo esc_url(home_url('/appointments/book')); ?>" class="btn" style="display: inline-block; width: 100%; text-align: center; padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-decoration: none; border-radius: 0.5rem; font-weight: 600; transition: opacity 0.3s;" onmouseover="this.style.opacity='0.9';" onmouseout="this.style.opacity='1';">
                            Book Appointment
                        </a>
                    </div>
                </div>
                
                <!-- Doctor 2 - Female -->
                <div style="background: white; border-radius: 0.75rem; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: transform 0.3s ease, box-shadow 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 12px rgba(0,0,0,0.15)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.1)';">
                    <div style="width: 100%; height: 300px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden;">
                        <?php
                        $doctor2_image = get_template_directory_uri() . '/assets/images/doctors/dr-sarah-johnson.jpg';
                        if (file_exists(get_template_directory() . '/assets/images/doctors/dr-sarah-johnson.jpg')) {
                            echo '<img src="' . esc_url($doctor2_image) . '" alt="Dr. Sarah Johnson" style="width: 200px; height: 200px; border-radius: 50%; object-fit: cover; border: 4px solid rgba(255,255,255,0.3);">';
                        } else {
                            echo '<div style="width: 200px; height: 200px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem; font-weight: 600;">SJ</div>';
                        }
                        ?>
                    </div>
                    <div style="padding: 2rem;">
                        <h3 style="font-size: 1.5rem; font-weight: 700; color: #1f2937; margin-bottom: 0.5rem;">Dr. Sarah Johnson</h3>
                        <p style="color: #667eea; font-size: 0.875rem; font-weight: 600; margin-bottom: 1rem;">MD, CCFP, FCFP</p>
                        <p style="color: #6b7280; line-height: 1.7; margin-bottom: 1.5rem; font-size: 0.95rem;">
                            Dr. Johnson is a dedicated Family Physician with expertise in women's health, pediatrics, and preventive medicine. 
                            She received her medical degree from McMaster University and has been practicing in Ontario for over 12 years. 
                            Dr. Johnson is passionate about building long-term relationships with her patients and their families.
                        </p>
                        <a href="<?php echo esc_url(home_url('/appointments/book')); ?>" class="btn" style="display: inline-block; width: 100%; text-align: center; padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-decoration: none; border-radius: 0.5rem; font-weight: 600; transition: opacity 0.3s;" onmouseover="this.style.opacity='0.9';" onmouseout="this.style.opacity='1';">
                            Book Appointment
                        </a>
                    </div>
                </div>
                
                <!-- Doctor 3 - Male -->
                <div style="background: white; border-radius: 0.75rem; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: transform 0.3s ease, box-shadow 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 12px rgba(0,0,0,0.15)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.1)';">
                    <div style="width: 100%; height: 300px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden;">
                        <?php
                        $doctor3_image = get_template_directory_uri() . '/assets/images/doctors/dr-james-wilson.jpg';
                        if (file_exists(get_template_directory() . '/assets/images/doctors/dr-james-wilson.jpg')) {
                            echo '<img src="' . esc_url($doctor3_image) . '" alt="Dr. James Wilson" style="width: 200px; height: 200px; border-radius: 50%; object-fit: cover; border: 4px solid rgba(255,255,255,0.3);">';
                        } else {
                            echo '<div style="width: 200px; height: 200px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem; font-weight: 600;">JW</div>';
                        }
                        ?>
                    </div>
                    <div style="padding: 2rem;">
                        <h3 style="font-size: 1.5rem; font-weight: 700; color: #1f2937; margin-bottom: 0.5rem;">Dr. James Wilson</h3>
                        <p style="color: #667eea; font-size: 0.875rem; font-weight: 600; margin-bottom: 1rem;">MD, CCFP, Dip Sport Med</p>
                        <p style="color: #6b7280; line-height: 1.7; margin-bottom: 1.5rem; font-size: 0.95rem;">
                            Dr. Wilson is a Family Physician with a special interest in sports medicine and musculoskeletal health. 
                            He completed his medical training at Queen's University and holds a Diploma in Sport Medicine. 
                            With over 10 years of experience, Dr. Wilson helps patients of all ages maintain active, healthy lifestyles.
                        </p>
                        <a href="<?php echo esc_url(home_url('/appointments/book')); ?>" class="btn" style="display: inline-block; width: 100%; text-align: center; padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-decoration: none; border-radius: 0.5rem; font-weight: 600; transition: opacity 0.3s;" onmouseover="this.style.opacity='0.9';" onmouseout="this.style.opacity='1';">
                            Book Appointment
                        </a>
                    </div>
                </div>
                
                <!-- Doctor 4 - Female -->
                <div style="background: white; border-radius: 0.75rem; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: transform 0.3s ease, box-shadow 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 12px rgba(0,0,0,0.15)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.1)';">
                    <div style="width: 100%; height: 300px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden;">
                        <?php
                        $doctor4_image = get_template_directory_uri() . '/assets/images/doctors/dr-emily-rodriguez.jpg';
                        if (file_exists(get_template_directory() . '/assets/images/doctors/dr-emily-rodriguez.jpg')) {
                            echo '<img src="' . esc_url($doctor4_image) . '" alt="Dr. Emily Rodriguez" style="width: 200px; height: 200px; border-radius: 50%; object-fit: cover; border: 4px solid rgba(255,255,255,0.3);">';
                        } else {
                            echo '<div style="width: 200px; height: 200px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem; font-weight: 600;">ER</div>';
                        }
                        ?>
                    </div>
                    <div style="padding: 2rem;">
                        <h3 style="font-size: 1.5rem; font-weight: 700; color: #1f2937; margin-bottom: 0.5rem;">Dr. Emily Rodriguez</h3>
                        <p style="color: #667eea; font-size: 0.875rem; font-weight: 600; margin-bottom: 1rem;">MD, CCFP, MRCGP</p>
                        <p style="color: #6b7280; line-height: 1.7; margin-bottom: 1.5rem; font-size: 0.95rem;">
                            Dr. Rodriguez is a bilingual Family Physician fluent in English and Spanish, specializing in family medicine 
                            and geriatric care. She completed her medical degree at the University of Ottawa and has extensive experience 
                            in managing complex chronic conditions. Dr. Rodriguez is committed to providing culturally sensitive care 
                            to diverse communities in Belleville.
                        </p>
                        <a href="<?php echo esc_url(home_url('/appointments/book')); ?>" class="btn" style="display: inline-block; width: 100%; text-align: center; padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-decoration: none; border-radius: 0.5rem; font-weight: 600; transition: opacity 0.3s;" onmouseover="this.style.opacity='0.9';" onmouseout="this.style.opacity='1';">
                            Book Appointment
                        </a>
                    </div>
                </div>
                
            </div>
            
            <h2 style="font-size: 2.5rem; margin: 3rem 0 2rem; color: #1f2937;">Our Services</h2>
            <ul style="color: #4b5563; line-height: 2; font-size: 1.125rem; list-style: none; padding: 0;">
                <li style="margin-bottom: 1rem; padding-left: 2rem; position: relative;">
                    <span style="position: absolute; left: 0; color: #2563eb;">✓</span>
                    <strong>Walk-in Clinic:</strong> No appointment needed. Quality medical care when you need it.
                </li>
                <li style="margin-bottom: 1rem; padding-left: 2rem; position: relative;">
                    <span style="position: absolute; left: 0; color: #2563eb;">✓</span>
                    <strong>Family Practice:</strong> Comprehensive family healthcare with dedicated family doctors.
                </li>
                <li style="margin-bottom: 1rem; padding-left: 2rem; position: relative;">
                    <span style="position: absolute; left: 0; color: #2563eb;">✓</span>
                    <strong>Telehealth:</strong> Virtual consultations from the comfort of your home.
                </li>
                <li style="margin-bottom: 1rem; padding-left: 2rem; position: relative;">
                    <span style="position: absolute; left: 0; color: #2563eb;">✓</span>
                    <strong>Emergency Care:</strong> 24/7 emergency medical services.
                </li>
            </ul>
        </div>
    </div>
</section>

<?php
get_footer();



