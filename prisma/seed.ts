import { PrismaClient, Role } from '@prisma/client';

const prisma = new PrismaClient();

async function main() {
  console.log('Seeding database...');

  // Create a sample location
  const location = await prisma.location.upsert({
    where: { id: 'loc-1' },
    update: {},
    create: {
      id: 'loc-1',
      name: 'FreshDew Main Campus',
      address: '2060 Ellesmere Rd Unit #3',
      city: 'Scarborough',
      province: 'Ontario',
      postalCode: 'M1H 2V6',
      country: 'Canada',
      latitude: 43.7764,
      longitude: -79.2318,
      phone: '(416) 123-4567',
      email: 'info@freshdew.ca',
      hours: {
        monday: { open: '08:00', close: '20:00' },
        tuesday: { open: '08:00', close: '20:00' },
        wednesday: { open: '08:00', close: '20:00' },
        thursday: { open: '08:00', close: '20:00' },
        friday: { open: '08:00', close: '20:00' },
        saturday: { open: '09:00', close: '17:00' },
        sunday: { open: '09:00', close: '17:00' },
      },
      facilities: ['Pharmacy', 'Lab', 'Imaging', 'Emergency'],
      isActive: true,
    },
  });

  console.log('Created location:', location.name);
  console.log('Seeding completed!');
}

main()
  .catch((e) => {
    console.error(e);
    process.exit(1);
  })
  .finally(async () => {
    await prisma.$disconnect();
  });






