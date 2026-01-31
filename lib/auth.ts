// lib/auth.ts
import { auth, clerkClient } from '@clerk/nextjs/server';
import { Role } from '@prisma/client';
import { prisma } from './db';

export async function getCurrentUser() {
  const { userId } = await auth();
  
  if (!userId) {
    return null;
  }
  
  const client = await clerkClient();
  const user = await client.users.getUser(userId);
  
  return {
    id: user.id,
    email: user.emailAddresses[0]?.emailAddress,
    firstName: user.firstName,
    lastName: user.lastName,
    imageUrl: user.imageUrl,
  };
}

export async function requireRole(requiredRole: Role) {
  const { userId } = await auth();
  
  if (!userId) {
    throw new Error('Unauthorized');
  }
  
  // Get user from database to check role
  const dbUser = await prisma.user.findUnique({
    where: { clerkUserId: userId },
    select: { role: true }
  });
  
  if (!dbUser || dbUser.role !== requiredRole) {
    throw new Error('Insufficient permissions');
  }
  
  return dbUser;
}