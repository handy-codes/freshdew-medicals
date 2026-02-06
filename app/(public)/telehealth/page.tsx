import { Metadata } from 'next';
import { Button } from '@/components/ui/button';
import Link from 'next/link';
import { Video, Calendar, Clock, Shield } from 'lucide-react';
import NextImage from 'next/image';

export const metadata: Metadata = {
  title: 'Telehealth - FreshDew Medical Clinic',
  description: 'Virtual consultations from the comfort of your home at FreshDew Medical Clinic.',
};

export default function TelehealthPage() {
  return (
    <div className="container mx-auto px-4 py-16">
      <div className="max-w-4xl mx-auto">
        <h1 className="text-4xl font-bold mb-8">Telehealth Services</h1>
        
        <div className="bg-gradient-to-r from-blue-50 to-teal-50 border border-blue-200 rounded-lg p-6 mb-8">
          <h2 className="text-2xl font-semibold mb-4">Virtual Healthcare at Your Fingertips</h2>
          <p className="text-lg mb-6">
            Connect with our healthcare professionals from anywhere in Canada through secure, 
            high-quality video consultations. No travel required, same quality care.
          </p>
          <Button asChild size="lg">
            <Link href="/appointments/book?type=TELEHEALTH">Book Telehealth Appointment</Link>
          </Button>
        </div>
        
        <div className="relative h-64 mb-8 rounded-lg overflow-hidden">
          <NextImage
            src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80"
            alt="Telehealth consultation"
            fill
            className="object-cover"
            unoptimized
          />
        </div>
        
        <div className="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
          <div>
            <h2 className="text-2xl font-semibold mb-4">Benefits</h2>
            <ul className="space-y-3">
              <li className="flex items-start space-x-3">
                <Video className="w-5 h-5 text-blue-600 mt-0.5" />
                <span>Convenient access from home</span>
              </li>
              <li className="flex items-start space-x-3">
                <Clock className="w-5 h-5 text-blue-600 mt-0.5" />
                <span>Flexible scheduling</span>
              </li>
              <li className="flex items-start space-x-3">
                <Shield className="w-5 h-5 text-blue-600 mt-0.5" />
                <span>Secure and private</span>
              </li>
              <li className="flex items-start space-x-3">
                <Calendar className="w-5 h-5 text-blue-600 mt-0.5" />
                <span>Same-day appointments available</span>
              </li>
            </ul>
          </div>
          
          <div>
            <h2 className="text-2xl font-semibold mb-4">What We Offer</h2>
            <ul className="space-y-3">
              <li className="flex items-start">
                <span className="text-blue-600 mr-2">•</span>
                <span>General consultations</span>
              </li>
              <li className="flex items-start">
                <span className="text-blue-600 mr-2">•</span>
                <span>Follow-up appointments</span>
              </li>
              <li className="flex items-start">
                <span className="text-blue-600 mr-2">•</span>
                <span>Prescription refills</span>
              </li>
              <li className="flex items-start">
                <span className="text-blue-600 mr-2">•</span>
                <span>Mental health support</span>
              </li>
            </ul>
          </div>
        </div>
        
        <div className="bg-gray-50 rounded-lg p-6">
          <h2 className="text-2xl font-semibold mb-4">How It Works</h2>
          <ol className="space-y-4">
            <li className="flex items-start">
              <span className="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold mr-4">1</span>
              <div>
                <p className="font-semibold">Book Your Appointment</p>
                <p className="text-gray-600">Schedule a telehealth visit online or by phone</p>
              </div>
            </li>
            <li className="flex items-start">
              <span className="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold mr-4">2</span>
              <div>
                <p className="font-semibold">Receive Confirmation</p>
                <p className="text-gray-600">Get a secure link and instructions via email</p>
              </div>
            </li>
            <li className="flex items-start">
              <span className="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold mr-4">3</span>
              <div>
                <p className="font-semibold">Join Your Appointment</p>
                <p className="text-gray-600">Click the link at your scheduled time to connect</p>
              </div>
            </li>
          </ol>
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

