import { auth } from '@clerk/nextjs/server';
import { redirect } from 'next/navigation';
import { prisma } from '@/lib/db';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';

export default async function StaffDashboard() {
  const { userId } = await auth();
  
  if (!userId) {
    redirect('/sign-in');
  }

  const user = await prisma.user.findUnique({
    where: { clerkUserId: userId },
    select: { role: true },
  });

  if (!user || (user.role !== 'STAFF' && user.role !== 'NURSE')) {
    redirect('/');
  }

  return (
    <div className="container mx-auto px-4 py-8">
      <h1 className="text-3xl font-bold mb-8">Staff Dashboard</h1>
      
      <Card>
        <CardHeader>
          <CardTitle>Welcome, Staff Member</CardTitle>
        </CardHeader>
        <CardContent>
          <p className="text-gray-600">Staff dashboard features coming soon...</p>
        </CardContent>
      </Card>
    </div>
  );
}

















