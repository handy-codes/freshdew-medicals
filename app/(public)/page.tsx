"use client";

import { motion } from "framer-motion";
import Image from "next/image";
import MapComponent from "@/components/MapComponent";
import Link from "next/link";
import { Button } from "@/components/ui/button";
import HeroSection from "@/components/sections/HeroSection";

export default function Home() {
  return (
    <div>
      {/* Hero Section */}
      <HeroSection />

      {/* Map Section */}
      <section className="py-16">
        <div className="container mx-auto px-4">
          <h2 className="text-3xl font-bold text-center mb-8">Find Our Location</h2>
          <div className="h-[400px] max-w-4xl mx-auto rounded-2xl overflow-hidden shadow-2xl">
            <MapComponent />
          </div>
        </div>
      </section>

      {/* Services Section */}
      <section className="py-16 bg-gray-50">
        <div className="container mx-auto px-4">
          <h2 className="text-3xl font-bold text-center mb-12">Our Services</h2>
          <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
            <motion.div
              initial={{ opacity: 0, y: 20 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              className="bg-white p-6 rounded-lg shadow-lg overflow-hidden"
            >
              <div className="h-48 mb-4 rounded-lg overflow-hidden relative bg-gray-200">
                <Image
                  src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?w=800&h=600&fit=crop&q=80"
                  alt="Doctors at walk-in clinic"
                  fill
                  className="object-cover"
                  unoptimized
                  onError={(e) => {
                    e.currentTarget.style.display = 'none';
                  }}
                />
              </div>
              <h3 className="text-xl font-semibold mb-4 text-gray-900">Walk-in Clinic</h3>
              <p className="text-gray-600 mb-4">
                Quick and convenient medical care without an appointment.
              </p>
              <Button asChild variant="outline" className="w-full text-gray-900 border-gray-300 hover:bg-gray-50">
                <Link href="/walk-in-clinic">Learn More</Link>
              </Button>
            </motion.div>
            <motion.div
              initial={{ opacity: 0, y: 20 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              transition={{ delay: 0.1 }}
              className="bg-white p-6 rounded-lg shadow-lg overflow-hidden"
            >
              <div className="h-48 mb-4 rounded-lg overflow-hidden relative bg-gray-200">
                <Image
                  src="https://images.unsplash.com/photo-1582750433449-648ed127bb54?w=800&h=600&fit=crop&q=80"
                  alt="Family doctor with patient"
                  fill
                  className="object-cover"
                  unoptimized
                  onError={(e) => {
                    e.currentTarget.style.display = 'none';
                  }}
                />
              </div>
              <h3 className="text-xl font-semibold mb-4 text-gray-900">Family Practice</h3>
              <p className="text-gray-600 mb-4">
                Comprehensive primary care for the whole family.
              </p>
              <Button asChild variant="outline" className="w-full text-gray-900 border-gray-300 hover:bg-gray-50">
                <Link href="/family-practice">Learn More</Link>
              </Button>
            </motion.div>
            <motion.div
              initial={{ opacity: 0, y: 20 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              transition={{ delay: 0.2 }}
              className="bg-white p-6 rounded-lg shadow-lg overflow-hidden"
            >
              <div className="h-48 mb-4 rounded-lg overflow-hidden relative bg-gray-200">
                <Image
                  src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1f?w=800&h=600&fit=crop&q=80"
                  alt="Telehealth video consultation"
                  fill
                  className="object-cover"
                  unoptimized
                  onError={(e) => {
                    e.currentTarget.style.display = 'none';
                  }}
                />
              </div>
              <h3 className="text-xl font-semibold mb-4 text-gray-900">Telehealth</h3>
              <p className="text-gray-600 mb-4">
                Virtual consultations from the comfort of your home.
              </p>
              <Button asChild variant="outline" className="w-full text-gray-900 border-gray-300 hover:bg-gray-50">
                <Link href="/telehealth">Learn More</Link>
              </Button>
            </motion.div>
          </div>
        </div>
      </section>
    </div>
  );
}


