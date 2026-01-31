import type { Metadata } from 'next';
import { Inter } from 'next/font/google';
import '../globals.css';
import Navigation from '@/components/layout/Navigation';
import Footer from '@/components/Footer';
import { ThemeProvider } from '@/components/providers/ThemeProvider';
import { Toaster } from '@/components/ui/toaster';
import { AIProvider } from '@/components/providers/AIProvider';
import AIChatButton from '@/components/features/AIChatButton';

const inter = Inter({ subsets: ['latin'] });

export const metadata: Metadata = {
  title: 'FreshDew Medical Clini - Advanced Healthcare in Canada',
  // title: 'HealthPlus Hospital - Advanced Healthcare in Canada',
  description: 'World-class hospital providing innovative healthcare services across Canada with cutting-edge technology and compassionate care.',
  keywords: ['hospital', 'healthcare', 'Canada', 'medical', 'telehealth', 'doctor'],
};

export default function PublicLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  return (
    <ThemeProvider attribute="class" defaultTheme="system" enableSystem>
      <AIProvider>
        <Navigation />
        <main className="min-h-screen">
          {children}
        </main>
        <Footer />
        <Toaster />
        {/* Keep AI button outside the navbar stacking context so it is always clickable */}
        <AIChatButton />
      </AIProvider>
    </ThemeProvider>
  );
}




