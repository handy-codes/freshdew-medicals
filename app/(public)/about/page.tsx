import { Metadata } from 'next';

export const metadata: Metadata = {
  // title: 'About Us - HealthPlus Hospital',
  title: 'About Us - FreshDew Medical Clinic',
  description: 'Learn about FreshDew Medical Clinic, a leading healthcare provider.',
};

export default function AboutPage() {
  return (
    <div className="container mx-auto px-4 py-16">
      <div className="max-w-4xl mx-auto">
        <h1 className="text-4xl font-bold mb-8">About FreshDew Medical Clinic</h1>
        {/* <h1 className="text-4xl font-bold mb-8">About HealthPlus Hospital</h1> */}
        
        <div className="prose prose-lg max-w-none">
          <p className="text-lg mb-6">
            Welcome to FreshDew Medical Clinic, a leading healthcare provider.
            {/* Welcome to HealthPlus Hospital, a leading healthcare provider in Canada. */}
            We are committed to delivering exceptional patient care with the latest medical technology and a compassionate team.
          </p>
          
          <h2 className="text-2xl font-semibold mt-8 mb-4">Our Mission</h2>
          <p className="mb-6">
            To provide world-class healthcare services that are accessible, innovative, and patient-centered.
            We strive to improve the health and well-being of all Canadians through excellence in medical care,
            cutting-edge technology, and a commitment to compassionate service.
          </p>
          
          <h2 className="text-2xl font-semibold mt-8 mb-4">Our Values</h2>
          <ul className="list-disc list-inside space-y-2 mb-6">
            <li>Patient-centered care</li>
            <li>Innovation and technology</li>
            <li>Compassion and empathy</li>
            <li>Excellence in medical practice</li>
            <li>Accessibility and inclusivity</li>
          </ul>
          
          <h2 className="text-2xl font-semibold mt-8 mb-4">Why Choose Us</h2>
          <p className="mb-6">
            FreshDew Medical Clinic combines the best of traditional healthcare with modern technology.
            Our team of experienced healthcare professionals is dedicated to providing personalized care
            that meets the unique needs of each patient.
          </p>
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






