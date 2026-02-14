import { Metadata } from 'next';
import { MapPin, Phone, Mail, Clock } from 'lucide-react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';

export const metadata: Metadata = {
  title: 'Contact Us - FreshDew Medical Clinic',
  description: 'Get in touch with FreshDew Medical Clinic. We are here to help with all your healthcare needs.',
};

export default function ContactPage() {
  return (
    <div className="container mx-auto px-4 py-16">
      <div className="max-w-6xl mx-auto">
        <h1 className="text-4xl font-bold mb-12 text-center">Contact Us</h1>
        
        <div className="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
          <Card>
            <CardHeader>
              <CardTitle>Get in Touch</CardTitle>
            </CardHeader>
            <CardContent>
              <form className="space-y-4">
                <div>
                  <label htmlFor="name" className="block text-sm font-medium mb-2">
                    Name
                  </label>
                  <Input id="name" placeholder="Your name" required />
                </div>
                <div>
                  <label htmlFor="email" className="block text-sm font-medium mb-2">
                    Email
                  </label>
                  <Input id="email" type="email" placeholder="your.email@example.com" required />
                </div>
                <div>
                  <label htmlFor="message" className="block text-sm font-medium mb-2">
                    Message
                  </label>
                  <textarea
                    id="message"
                    className="flex min-h-[120px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                    placeholder="Your message..."
                    required
                  />
                </div>
                <Button type="submit" className="w-full">
                  Send Message
                </Button>
              </form>
            </CardContent>
          </Card>
          
          <div className="space-y-6">
            <Card>
              <CardHeader>
                <CardTitle className="flex items-center space-x-2">
                  <MapPin className="w-5 h-5" />
                  <span>Location</span>
                </CardTitle>
              </CardHeader>
              <CardContent>
                <address className="not-italic text-gray-700">
                  135 Cannifton Road, Unit 2 & 3<br />
                  Belleville, Ontario, K8N 4V4<br />
                  Canada
                </address>
              </CardContent>
            </Card>
            
            <Card>
              <CardHeader>
                <CardTitle className="flex items-center space-x-2">
                  <Phone className="w-5 h-5" />
                  <span>Phone</span>
                </CardTitle>
              </CardHeader>
              <CardContent>
                <p className="text-gray-700">
                  <a href="tel:+16132430110" className="hover:text-blue-600">
                    (613) 243-0110
                  </a>
                </p>
                <p className="text-sm text-gray-500 mt-2">Fax: (613) 243-0321</p>
                <p className="text-sm text-gray-500 mt-2">Emergency: 911</p>
              </CardContent>
            </Card>
            
            <Card>
              <CardHeader>
                <CardTitle className="flex items-center space-x-2">
                  <Mail className="w-5 h-5" />
                  <span>Email</span>
                </CardTitle>
              </CardHeader>
              <CardContent>
                <p className="text-gray-700">
                  <a href="mailto:info@freshdewmedicalclinic.com" className="hover:text-blue-600">
                    info@freshdewmedicalclinic.com
                  </a>
                </p>
                <p className="text-sm text-gray-500 mt-2">
                  <a href="https://www.freshdewmedicalclinic.com" target="_blank" rel="noopener noreferrer" className="hover:text-blue-600">
                    www.freshdewmedicalclinic.com
                  </a>
                </p>
              </CardContent>
            </Card>
            
            <Card>
              <CardHeader>
                <CardTitle className="flex items-center space-x-2">
                  <Clock className="w-5 h-5" />
                  <span>Hours</span>
                </CardTitle>
              </CardHeader>
              <CardContent>
                <div className="text-gray-700 space-y-1">
                  <p>Monday - Friday: 8:00 AM - 8:00 PM</p>
                  <p>Saturday - Sunday: 9:00 AM - 5:00 PM</p>
                </div>
              </CardContent>
            </Card>
          </div>
        </div>
      </div>
    </div>
  );
}






