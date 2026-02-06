import { Metadata } from 'next';
import { Button } from '@/components/ui/button';
import Link from 'next/link';
import { Users, Heart, Calendar, Stethoscope } from 'lucide-react';

export const metadata: Metadata = {
  title: 'Family Practice - FreshDew Medical Clinic',
  description: 'Comprehensive primary care for the whole family at FreshDew Medical Clinic.',
};

export default function FamilyPracticePage() {
  return (
    <div className="container mx-auto px-4 py-16">
      <div className="max-w-4xl mx-auto">
        <h1 className="text-4xl font-bold mb-8">Family Practice</h1>
        
        <div className="bg-gradient-to-r from-blue-50 to-teal-50 border border-blue-200 rounded-lg p-6 mb-8">
          <h2 className="text-2xl font-semibold mb-4">Your Family's Health Partner</h2>
          <p className="text-lg mb-6">
            Our family practice provides comprehensive primary care for patients of all ages.
            From newborns to seniors, we're here to support your family's health journey.
          </p>
          <Button asChild size="lg">
            <Link href="/appointments/book?type=family-practice">Book an Appointment</Link>
          </Button>
        </div>
        
        <div className="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
          <div>
            <h2 className="text-2xl font-semibold mb-4">Services</h2>
            <ul className="space-y-3">
              <li className="flex items-start space-x-3">
                <Stethoscope className="w-5 h-5 text-blue-600 mt-0.5" />
                <span>Preventive care and health screenings</span>
              </li>
              <li className="flex items-start space-x-3">
                <Heart className="w-5 h-5 text-blue-600 mt-0.5" />
                <span>Chronic disease management</span>
              </li>
              <li className="flex items-start space-x-3">
                <Users className="w-5 h-5 text-blue-600 mt-0.5" />
                <span>Pediatric care</span>
              </li>
              <li className="flex items-start space-x-3">
                <Calendar className="w-5 h-5 text-blue-600 mt-0.5" />
                <span>Annual physical exams</span>
              </li>
            </ul>
          </div>
          
          <div>
            <h2 className="text-2xl font-semibold mb-4">Benefits</h2>
            <ul className="space-y-3">
              <li className="flex items-start">
                <span className="text-blue-600 mr-2">•</span>
                <span>Continuity of care with the same physician</span>
              </li>
              <li className="flex items-start">
                <span className="text-blue-600 mr-2">•</span>
                <span>Comprehensive health records</span>
              </li>
              <li className="flex items-start">
                <span className="text-blue-600 mr-2">•</span>
                <span>Personalized treatment plans</span>
              </li>
              <li className="flex items-start">
                <span className="text-blue-600 mr-2">•</span>
                <span>Coordination with specialists</span>
              </li>
            </ul>
          </div>
        </div>
        
        <div className="bg-gray-50 rounded-lg p-6">
          <h2 className="text-2xl font-semibold mb-4">Accepting New Patients</h2>
          <p className="mb-4">
            We are currently accepting new patients for our family practice.
            To register, please book an initial consultation appointment or contact our office.
          </p>
          <Button asChild variant="outline">
            <Link href="/contact">Contact Us</Link>
          </Button>
        </div>

        {/* Image Upload Section */}
        <div className="mt-12 space-y-6">
          <h2 className="text-2xl font-semibold mb-6">Upload Images</h2>
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div className="border-2 border-dashed border-gray-300 rounded-lg p-6">
              <label className="block text-lg font-semibold mb-4 text-gray-700">GH</label>
              <input
                type="file"
                accept="image/*"
                multiple
                className="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
              />
            </div>
            <div className="border-2 border-dashed border-gray-300 rounded-lg p-6">
              <label className="block text-lg font-semibold mb-4 text-gray-700">OC</label>
              <input
                type="file"
                accept="image/*"
                multiple
                className="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}






