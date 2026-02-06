import { Metadata } from 'next';
import { Button } from '@/components/ui/button';
import Link from 'next/link';
import { Clock, MapPin, Phone, Calendar } from 'lucide-react';

export const metadata: Metadata = {
  title: 'Walk-in Clinic - HealthPlus Hospital',
  description: 'Quick and convenient medical care without an appointment at HealthPlus Hospital.',
};

export default function WalkInClinicPage() {
  return (
    <div className="container mx-auto px-4 py-16">
      <div className="max-w-4xl mx-auto">
        <h1 className="text-4xl font-bold mb-8">Walk-in Clinic</h1>
        
        <div className="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
          <h2 className="text-2xl font-semibold mb-4">Quick Access to Medical Care</h2>
          <p className="text-lg mb-6">
            Our walk-in clinic provides convenient access to medical care without the need for an appointment.
            Perfect for non-emergency medical issues that need prompt attention.
          </p>
          <Button asChild size="lg">
            <Link href="/appointments/book?type=walk-in">Book a Visit</Link>
          </Button>
        </div>
        
        <div className="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
          <div className="flex items-start space-x-4">
            <Clock className="w-6 h-6 text-blue-600 mt-1" />
            <div>
              <h3 className="font-semibold mb-2">Hours of Operation</h3>
              <p className="text-gray-600">
                Monday - Friday: 8:00 AM - 8:00 PM<br />
                Saturday - Sunday: 9:00 AM - 5:00 PM
              </p>
            </div>
          </div>
          
          <div className="flex items-start space-x-4">
            <MapPin className="w-6 h-6 text-blue-600 mt-1" />
            <div>
              <h3 className="font-semibold mb-2">Location</h3>
              <p className="text-gray-600">
                2060 Ellesmere Rd Unit #3<br />
                Scarborough, ON M1H 2V6
              </p>
            </div>
          </div>
        </div>
        
        <div className="mb-8">
          <h2 className="text-2xl font-semibold mb-4">Services Offered</h2>
          <ul className="list-disc list-inside space-y-2 text-gray-700">
            <li>General medical consultations</li>
            <li>Minor injury treatment</li>
            <li>Prescription refills</li>
            <li>Health screenings</li>
            <li>Vaccinations</li>
            <li>Lab requisitions</li>
          </ul>
        </div>
        
        <div className="bg-gray-50 rounded-lg p-6">
          <h2 className="text-2xl font-semibold mb-4">Important Information</h2>
          <p className="mb-4">
            Our walk-in clinic operates on a first-come, first-served basis. Wait times may vary depending on patient volume.
            For life-threatening emergencies, please call 911 or visit your nearest emergency department.
          </p>
          <div className="flex items-center space-x-2 text-red-600">
            <Phone className="w-5 h-5" />
            <span className="font-semibold">Emergency: 911</span>
          </div>
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

















