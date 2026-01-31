# HealthPlus Hospital - Modern Healthcare Web Application

A comprehensive, modern hospital management web application built for Canadian healthcare providers using Next.js 16, TypeScript, Prisma, and Clerk authentication.

## Features

- 🏥 **Patient Management**: Complete patient profiles, medical records, and appointment scheduling
- 👨‍⚕️ **Doctor Dashboard**: Appointment management, patient records, and telehealth sessions
- 📅 **Appointment System**: Book, manage, and track appointments (in-person, telehealth, urgent care)
- 💬 **AI Assistant**: Powered by Llama 3.1 8B via Hugging Face (free tier available)
- 🗺️ **Location Services**: Free OpenStreetMap integration (no API key required)
- 🔐 **Secure Authentication**: Clerk-based authentication with role-based access control
- 📱 **Responsive Design**: Modern, mobile-first UI with dark mode support
- 🇨🇦 **Canadian Healthcare**: Built specifically for Canadian healthcare regulations

## Tech Stack

- **Framework**: Next.js 16.1.4 (App Router)
- **Language**: TypeScript
- **Database**: PostgreSQL (via Prisma ORM)
- **Authentication**: Clerk
- **Styling**: Tailwind CSS v4
- **AI**: Hugging Face Inference API (Llama 3.1 8B)
- **Maps**: OpenStreetMap (free, no API key)

## Getting Started

### Prerequisites

- Node.js 20+ 
- PostgreSQL database (Neon, Supabase, or local)
- Clerk account (free tier available)
- Hugging Face account (free tier available)

### Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd mekxus_hosptital
   ```

2. **Install dependencies**
   ```bash
   npm install
   ```

3. **Set up environment variables**
   
   Create a `.env.local` file in the root directory:
   ```env
   # Database (Use your Neon PostgreSQL connection string)
   DATABASE_URL="postgresql://user:password@host:5432/database"

   # Clerk Authentication
   NEXT_PUBLIC_CLERK_PUBLISHABLE_KEY=pk_test_...
   CLERK_SECRET_KEY=sk_test_...
   CLERK_WEBHOOK_SECRET=whsec_...

   # AI Services (Required)
   HUGGINGFACE_API_KEY=hf_...

   # Node Environment
   NODE_ENV=development
   ```

   See [ENV_SETUP.md](./ENV_SETUP.md) for detailed instructions on obtaining these values.

4. **Set up the database**
   ```bash
   npm run prisma:generate
   npm run prisma:push
   npm run prisma:seed
   ```

5. **Start the development server**
```bash
npm run dev
   ```

6. **Open your browser**
   
   Navigate to [http://localhost:3000](http://localhost:3000)

## Project Structure

```
mekxus_hosptital/
├── app/
│   ├── (public)/          # Public pages (home, about, services)
│   ├── (auth)/            # Authentication pages
│   ├── (dashboard)/       # Role-based dashboards
│   └── api/               # API routes
├── components/
│   ├── ui/                # Reusable UI components
│   ├── providers/         # Context providers
│   └── layout/            # Layout components
├── lib/                   # Utilities & database client
├── prisma/                # Database schema & migrations
└── public/                # Static assets
```

## Available Scripts

- `npm run dev` - Start development server
- `npm run build` - Build for production
- `npm run start` - Start production server
- `npm run prisma:generate` - Generate Prisma Client
- `npm run prisma:push` - Push schema to database
- `npm run prisma:migrate` - Create and run migrations
- `npm run prisma:studio` - Open Prisma Studio
- `npm run prisma:seed` - Seed database with sample data

## Environment Variables

See [ENV_SETUP.md](./ENV_SETUP.md) for complete documentation on setting up environment variables.

### Required Variables

- `DATABASE_URL` - PostgreSQL connection string
- `NEXT_PUBLIC_CLERK_PUBLISHABLE_KEY` - Clerk publishable key
- `CLERK_SECRET_KEY` - Clerk secret key
- `CLERK_WEBHOOK_SECRET` - Clerk webhook secret (for user sync)
- `HUGGINGFACE_API_KEY` - Hugging Face API key (for AI assistant)

## Features in Detail

### AI Assistant

The AI assistant uses Llama 3.1 8B via Hugging Face Inference API. It's configured to:
- Help with appointment booking
- Provide general health information
- Direct users to appropriate services
- Handle emergency situations appropriately

### Maps Integration

The application uses OpenStreetMap (free, no API key required) instead of Google Maps to avoid costs.

### Authentication & Authorization

- **Roles**: SUPER_ADMIN, ADMIN, DOCTOR, NURSE, STAFF, PATIENT, CAREGIVER
- **Protected Routes**: Dashboard routes require authentication
- **Public Routes**: Home, about, services, contact pages

## Database Schema

The application includes comprehensive models for:
- Users & Profiles
- Patients & Medical Records
- Doctors & Appointments
- Prescriptions & Billing
- Telehealth Sessions
- Notifications & Messages
- Audit Logs

See `prisma/schema.prisma` for the complete schema.

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Submit a pull request

## License

This project is private and proprietary.

## Support

For issues or questions, please refer to the [ENV_SETUP.md](./ENV_SETUP.md) documentation or create an issue in the repository.

---

Built with ❤️ for Canadian Healthcare
