import { NextResponse } from 'next/server';
import { prisma } from '@/lib/db';

export async function GET() {
  try {
    const locations = await prisma.location.findMany({
      where: { isActive: true },
      select: {
        id: true,
        name: true,
        address: true,
        city: true,
        province: true,
        postalCode: true,
        phone: true,
        email: true,
        latitude: true,
        longitude: true,
        facilities: true,
        hours: true,
      },
    });

    return NextResponse.json({ locations });
  } catch (error) {
    console.error('Locations API error:', error);
    return NextResponse.json(
      { error: 'Failed to fetch locations' },
      { status: 500 }
    );
  }
}

















