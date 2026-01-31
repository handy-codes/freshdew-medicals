// components/sections/HeroSection.tsx
'use client';

import { useState } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { Play, Pause, Image as ImageIcon } from 'lucide-react';
import { Button } from '@/components/ui/button';
import { cn } from '@/lib/utils';

export default function HeroSection() {
  const [isVideoPlaying, setIsVideoPlaying] = useState(false);
  const [activeMedia, setActiveMedia] = useState<'image' | 'video'>('image');

  const heroImage = {
    url: 'https://media.istockphoto.com/id/2218491828/photo/medical-team-smiling-at-camera-in-hospital-corridor.webp?a=1&b=1&s=612x612&w=0&k=20&c=lnb7UnuwBPXinOObvP5XCAslVTvmQj0j2UzyXF8Oe-M=',
    alt: 'Medical team smiling at camera in hospital corridor',
  };

  const heroVideo = 'https://assets.mixkit.co/videos/preview/mixkit-doctor-examining-a-patient-4326-large.mp4';

  return (
    <section className="relative h-screen overflow-hidden">
      {/* Background Media */}
      <div id="hero-media" className="absolute inset-0">
        <AnimatePresence mode="wait">
          {activeMedia === 'image' ? (
            <motion.div
              key="hero-image"
              initial={{ opacity: 0 }}
              animate={{ opacity: 1 }}
              exit={{ opacity: 0 }}
              transition={{ duration: 0.5 }}
              className="relative h-full w-full"
            >
              <div className="absolute inset-0 bg-gradient-to-r from-blue-900/70 via-blue-900/40 to-transparent z-10" />
              <img
                src={heroImage.url}
                alt={heroImage.alt}
                className="h-full w-full object-cover"
              />
            </motion.div>
          ) : (
            <motion.div
              key="hero-video"
              initial={{ opacity: 0 }}
              animate={{ opacity: 1 }}
              exit={{ opacity: 0 }}
              transition={{ duration: 0.5 }}
              className="relative h-full w-full"
            >
              <div className="absolute inset-0 bg-gradient-to-r from-blue-900/70 via-blue-900/40 to-transparent z-10" />
              <video
                className="h-full w-full object-cover"
                src={heroVideo}
                autoPlay={isVideoPlaying}
                muted
                loop
                playsInline
              />
            </motion.div>
          )}
        </AnimatePresence>
      </div>

      {/* Content */}
      <div className="relative z-20 h-full flex items-center">
        <div className="container mx-auto px-4">
          <motion.div
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.8, delay: 0.2 }}
            className="max-w-3xl"
          >
            <div className="inline-flex items-center px-3 py-1 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 mb-6">
              <span className="w-2 h-2 bg-green-400 rounded-full animate-pulse mr-2" />
              <span className="text-white/90 text-sm font-medium">
                Accepting New Patients
              </span>
            </div>

            <h1 className="text-5xl md:text-7xl font-bold text-white mb-6 leading-tight">
              Advanced Healthcare
              <span className="block text-transparent bg-clip-text bg-gradient-to-r from-cyan-300 to-blue-300">
                For All Canadians
              </span>
            </h1>

            <p className="text-xl text-white/80 mb-8 max-w-2xl">
              Experience world-class medical care with cutting-edge technology
              and compassionate professionals.
            </p>

            <div className="flex flex-wrap gap-4">
              <Button
                size="lg"
                className="bg-white text-blue-900 hover:bg-gray-100 px-8 rounded-full text-lg font-semibold"
              >
                Find a Doctor
              </Button>
              <Button
                size="lg"
                variant="outline"
                className="border-white text-white hover:bg-white/10 px-8 rounded-full text-lg font-semibold"
              >
                Book Appointment
              </Button>
              <Button
                size="lg"
                variant="ghost"
                className="text-white hover:bg-white/5 px-8 rounded-full text-lg font-semibold"
              >
                Virtual Visit
              </Button>
            </div>

            {/* Stats */}
            {/* <motion.div
              initial={{ opacity: 0 }}
              animate={{ opacity: 1 }}
              transition={{ delay: 0.5 }}
              className="grid grid-cols-2 md:grid-cols-4 gap-6 mt-16"
            >
              {[
                { value: '24/7', label: 'Emergency Care' },
                { value: '98%', label: 'Patient Satisfaction' },
                { value: '50+', label: 'Specialists' },
                { value: '15min', label: 'Avg Wait Time' },
              ].map((stat, index) => (
                <div
                  key={stat.label}
                  className="text-center p-4 rounded-2xl backdrop-blur-sm bg-white/5 border border-white/10"
                >
                  <div className="text-3xl font-bold text-white mb-1">
                    {stat.value}
                  </div>
                  <div className="text-sm text-white/70">
                    {stat.label}
                  </div>
                </div>
              ))}
            </motion.div> */}
          </motion.div>
        </div>
      </div>

      {/* Media Controls */}
      <div className="absolute bottom-8 right-8 z-30 flex items-center space-x-2">
        <div className="flex items-center space-x-2 backdrop-blur-sm bg-black/30 rounded-full p-2">
          <Button
            size="icon"
            variant="ghost"
            onClick={() => setActiveMedia('image')}
            className={cn(
              'text-white hover:bg-white/20',
              activeMedia === 'image' && 'bg-white/30'
            )}
          >
            <ImageIcon className="w-4 h-4" />
          </Button>
          
          <Button
            size="icon"
            variant="ghost"
            onClick={() => setActiveMedia('video')}
            className={cn(
              'text-white hover:bg-white/20',
              activeMedia === 'video' && 'bg-white/30'
            )}
          >
            {activeMedia === 'video' && isVideoPlaying ? (
              <Pause className="w-4 h-4" />
            ) : (
              <Play className="w-4 h-4" />
            )}
          </Button>

        </div>
      </div>

      {/* Scroll Indicator */}
      <motion.div
        animate={{ y: [0, 10, 0] }}
        transition={{ repeat: Infinity, duration: 1.5 }}
        className="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-30"
      >
        <div className="w-6 h-10 border-2 border-white/30 rounded-full flex justify-center">
          <div className="w-1 h-3 bg-white/50 rounded-full mt-2" />
        </div>
      </motion.div>
    </section>
  );
}