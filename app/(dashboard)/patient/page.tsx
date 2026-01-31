import { auth } from '@clerk/nextjs/server';
import { redirect } from 'next/navigation';
import { prisma } from '@/lib/db';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Calendar, FileText, Pill, MessageSquare } from 'lucide-react';
import Link from 'next/link';
import { Button } from '@/components/ui/button';

export default async function PatientDashboard() {
  const { userId } = await auth();
  
  if (!userId) {
    redirect('/sign-in');
  }

  const user = await prisma.user.findUnique({
    where: { clerkUserId: userId },
    include: {
      appointments: {
        take: 5,
        orderBy: { dateTime: 'desc' },
        include: { doctor: { include: { user: { include: { profile: true } } } } },
      },
      prescriptions: {
        take: 5,
        orderBy: { prescribedAt: 'desc' },
      },
      medicalRecords: {
        take: 5,
        orderBy: { createdAt: 'desc' },
      },
    },
  });

  if (!user || user.role !== 'PATIENT') {
    redirect('/');
  }

  return (
    <div className="container mx-auto px-4 py-8">
      <h1 className="text-3xl font-bold mb-8">Patient Dashboard</h1>
      
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <Card>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm font-medium">Upcoming Appointments</CardTitle>
            <Calendar className="h-4 w-4 text-muted-foreground" />
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">{user.appointments.length}</div>
          </CardContent>
        </Card>
        
        <Card>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm font-medium">Active Prescriptions</CardTitle>
            <Pill className="h-4 w-4 text-muted-foreground" />
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">{user.prescriptions.length}</div>
          </CardContent>
        </Card>
        
        <Card>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm font-medium">Medical Records</CardTitle>
            <FileText className="h-4 w-4 text-muted-foreground" />
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">{user.medicalRecords.length}</div>
          </CardContent>
        </Card>
        
        <Card>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm font-medium">Messages</CardTitle>
            <MessageSquare className="h-4 w-4 text-muted-foreground" />
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">0</div>
          </CardContent>
        </Card>
      </div>
      
      <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <Card>
          <CardHeader>
            <CardTitle>Recent Appointments</CardTitle>
          </CardHeader>
          <CardContent>
            {user.appointments.length > 0 ? (
              <div className="space-y-4">
                {user.appointments.map((appointment) => (
                  <div key={appointment.id} className="border-b pb-4 last:border-0">
                    <p className="font-semibold">
                      {new Date(appointment.dateTime).toLocaleDateString()}
                    </p>
                    <p className="text-sm text-gray-600">
                      {appointment.doctor.user.profile?.firstName} {appointment.doctor.user.profile?.lastName}
                    </p>
                    <p className="text-sm text-gray-500">{appointment.status}</p>
                  </div>
                ))}
              </div>
            ) : (
              <p className="text-gray-500">No appointments yet</p>
            )}
            <Button asChild className="mt-4" variant="outline">
              <Link href="/patient/appointments">View All</Link>
            </Button>
          </CardContent>
        </Card>
        
        <Card>
          <CardHeader>
            <CardTitle>Quick Actions</CardTitle>
          </CardHeader>
          <CardContent className="space-y-2">
            <Button asChild className="w-full" variant="outline">
              <Link href="/patient/appointments/book">Book Appointment</Link>
            </Button>
            <Button asChild className="w-full" variant="outline">
              <Link href="/patient/records">View Medical Records</Link>
            </Button>
            <Button asChild className="w-full" variant="outline">
              <Link href="/patient/prescriptions">View Prescriptions</Link>
            </Button>
            <Button asChild className="w-full" variant="outline">
              <Link href="/patient/telehealth">Start Telehealth Session</Link>
            </Button>
          </CardContent>
        </Card>
      </div>
    </div>
  );
}











