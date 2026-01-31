import { ClerkProvider } from '@clerk/nextjs';
import { ThemeProvider } from '@/components/providers/ThemeProvider';
import { Toaster } from '@/components/ui/toaster';
import { redirect } from 'next/navigation';
import { auth } from '@clerk/nextjs/server';
import { prisma } from '@/lib/db';

export default async function DashboardLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  const { userId } = await auth();
  
  if (!userId) {
    redirect('/sign-in');
  }

  // Get user role from database
  const user = await prisma.user.findUnique({
    where: { clerkUserId: userId },
    select: { role: true },
  });

  if (!user) {
    redirect('/sign-in');
  }

  // Redirect based on role
  const roleRoutes: Record<string, string> = {
    PATIENT: '/patient',
    DOCTOR: '/doctor',
    ADMIN: '/admin',
    SUPER_ADMIN: '/admin',
    NURSE: '/staff',
    STAFF: '/staff',
  };

  return (
    <ClerkProvider>
      <ThemeProvider attribute="class" defaultTheme="system" enableSystem>
        <div className="min-h-screen bg-background">
          {children}
        </div>
        <Toaster />
      </ThemeProvider>
    </ClerkProvider>
  );
}
