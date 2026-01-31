// components/sections/HeroSection.tsx
'use client';

import { useState, useEffect } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { Play, Pause, Volume2, VolumeX, Maximize, Image as ImageIcon } from 'lucide-react';
import { Button } from '@/components/ui/button';
import { cn } from '@/lib/utils';

export default function HeroSection() {
  const [isVideoPlaying, setIsVideoPlaying] = useState(false);
  const [isMuted, setIsMuted] = useState(true);
  const [activeMedia, setActiveMedia] = useState<'image' | 'video'>('image');
  const [isFullscreen, setIsFullscreen] = useState(false);

  const heroImages = [
    {
      url: 'https://images.unsplash.com/photo-1516549655669-df6654e435f9?auto=format&fit=crop&w=2070',
      alt: 'Modern hospital facility',
    },
    {
      url: 'https://images.unsplash.com/photo-1586773860418-dc22f8b874bc?auto=format&fit=crop&w=2070',
      alt: 'Medical team in operation',
    },
    {
      url: 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1f?auto=format&fit=crop&w=2070',
      alt: 'Advanced medical equipment',
    },
  ];

  const heroVideo = 'https://assets.mixkit.co/videos/preview/mixkit-doctor-examining-a-patient-4326-large.mp4';

  const toggleFullscreen = () => {
    const element = document.getElementById('hero-media');
    if (!element) return;

    if (!document.fullscreenElement) {
      element.requestFullscreen().catch(err => {
        console.log(`Error attempting to enable fullscreen: ${err.message}`);
      });
      setIsFullscreen(true);
    } else {
      document.exitFullscreen();
      setIsFullscreen(false);
    }
  };

  useEffect(() => {
    const handleFullscreenChange = () => {
      setIsFullscreen(!!document.fullscreenElement);
    };

    document.addEventListener('fullscreenchange', handleFullscreenChange);
    return () => document.removeEventListener('fullscreenchange', handleFullscreenChange);
  }, []);

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
              <div
                className="h-full w-full bg-cover bg-center bg-no-repeat"
                style={{ backgroundImage: `url(${heroImages[0].url})` }}
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
                muted={isMuted}
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
              Experience world-class medical care with cutting-edge technology, 
              compassionate professionals, and innovative telehealth solutions—all from the comfort of your home.
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
            <motion.div
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
            </motion.div>
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

          {activeMedia === 'video' && (
            <Button
              size="icon"
              variant="ghost"
              onClick={() => setIsMuted(!isMuted)}
              className="text-white hover:bg-white/20"
            >
              {isMuted ? (
                <VolumeX className="w-4 h-4" />
              ) : (
                <Volume2 className="w-4 h-4" />
              )}
            </Button>
          )}

          <Button
            size="icon"
            variant="ghost"
            onClick={toggleFullscreen}
            className="text-white hover:bg-white/20"
          >
            <Maximize className="w-4 h-4" />
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