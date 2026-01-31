// app/api/appointments/book/route.ts
import { NextRequest, NextResponse } from 'next/server';
import { prisma } from '@/lib/db';
import { z } from 'zod';

const appointmentSchema = z.object({
  fullName: z.string().min(2),
  email: z.string().email(),
  phone: z.string().min(5),
  date: z.string(),
  time: z.string(),
  type: z.enum(['IN_PERSON', 'TELEHEALTH', 'URGENT_CARE']),
  reason: z.string().optional(),
  symptoms: z.string().optional(),
});

export async function POST(request: NextRequest) {
  try {
    const body = await request.json();
    const validation = appointmentSchema.safeParse(body);

    if (!validation.success) {
      return NextResponse.json(
        { error: 'Invalid input', details: validation.error.errors },
        { status: 400 }
      );
    }

    const { fullName, email, phone, date, time, type, reason, symptoms } = validation.data;

    // Combine date and time
    const dateTime = new Date(`${date}T${time}`);

    // Ensure at least one doctor exists (development bootstrap)
    let doctor = await prisma.doctor.findFirst({
      where: { isAcceptingPatients: true },
    });

    if (!doctor) {
      const doctorUser = await prisma.user.upsert({
        where: { email: 'doctor@freshdew.local' },
        update: {},
        create: {
          clerkUserId: 'local:doctor',
          email: 'doctor@freshdew.local',
          role: 'DOCTOR',
          profile: {
            create: {
              firstName: 'Alex',
              lastName: 'Morgan',
              dateOfBirth: new Date('1985-01-01'),
              city: 'Scarborough',
              province: 'Ontario',
              postalCode: 'M1H 2V6',
              country: 'Canada',
              phone: '(416) 123-4567',
              address: '2060 Ellesmere Rd Unit #3',
            },
          },
        },
        include: { profile: true },
      });

      doctor = await prisma.doctor.create({
        data: {
          userId: doctorUser.id,
          licenseNumber: 'ON-' + Math.random().toString(16).slice(2, 10).toUpperCase(),
          specialty: 'Family Medicine',
          qualifications: ['MD', 'CFPC'],
          yearsOfExperience: 10,
          workingHours: {
            monday: { start: '09:00', end: '17:00' },
            tuesday: { start: '09:00', end: '17:00' },
            wednesday: { start: '09:00', end: '17:00' },
            thursday: { start: '09:00', end: '17:00' },
            friday: { start: '09:00', end: '17:00' },
          },
          isAcceptingPatients: true,
          maxPatientsPerDay: 20,
          officePhone: '(416) 123-4567',
          officeEmail: 'doctor@freshdew.local',
          officeLocation: 'FreshDew Medical Clinic',
        },
      });
    }

    // Prevent double-booking near the requested time
    const existing = await prisma.appointment.findFirst({
      where: {
        doctorId: doctor.id,
        status: { in: ['SCHEDULED', 'CONFIRMED'] },
        dateTime: {
          gte: new Date(dateTime.getTime() - 30 * 60000),
          lte: new Date(dateTime.getTime() + 30 * 60000),
        },
      },
    });
    if (existing) {
      return NextResponse.json(
        { error: 'This time slot is already booked. Please choose another time.' },
        { status: 400 }
      );
    }

    // Get patient
    const patientClerkId = `guest:${email.toLowerCase()}`;
    const patient = await prisma.user.upsert({
      where: { email: email.toLowerCase() },
      update: {},
      create: {
        clerkUserId: patientClerkId,
        email: email.toLowerCase(),
        role: 'PATIENT',
        profile: {
          create: {
            firstName: fullName.split(' ')[0] || 'Guest',
            lastName: fullName.split(' ').slice(1).join(' ') || 'Patient',
            dateOfBirth: new Date('1990-01-01'),
            city: 'Scarborough',
            province: 'Ontario',
            postalCode: 'M1H 2V6',
            country: 'Canada',
            phone,
          },
        },
      },
    });

    // Create appointment
    const appointment = await prisma.appointment.create({
      data: {
        patientId: patient.id,
        doctorId: doctor.id,
        dateTime,
        type,
        reason: reason || '',
        symptoms: symptoms ? symptoms.split(',').map(s => s.trim()) : [],
        status: 'SCHEDULED',
      },
      include: {
        doctor: {
          include: {
            user: {
              include: { profile: true }
            }
          }
        },
        location: true,
      }
    });

    // Send confirmation email (in production)
    // await sendConfirmationEmail(patient.email, appointment);

    return NextResponse.json({
      success: true,
      appointment,
      message: 'Appointment booked successfully'
    }, { status: 201 });

  } catch (error) {
    console.error('Appointment booking error:', error);
    return NextResponse.json(
      { error: 'Internal server error' },
      { status: 500 }
    );
  }
}