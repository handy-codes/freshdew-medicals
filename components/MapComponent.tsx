"use client";

import { MapPin, ExternalLink } from "lucide-react";
import { Button } from "@/components/ui/button";

// Interactive OpenStreetMap embed
export default function MapComponent() {
  const hospitalLocation = {
    lat: 44.1628, // Belleville, ON - 135 Cannifton Road
    lng: -77.3831,
  };

  // OpenStreetMap embed URL (free, no API key needed)
  const mapEmbedUrl = `https://www.openstreetmap.org/export/embed.html?bbox=${hospitalLocation.lng - 0.015},${hospitalLocation.lat - 0.01},${hospitalLocation.lng + 0.015},${hospitalLocation.lat + 0.01}&layer=mapnik&marker=${hospitalLocation.lat},${hospitalLocation.lng}`;
  
  // Direct link to OpenStreetMap
  const mapDirectUrl = `https://www.openstreetmap.org/?mlat=${hospitalLocation.lat}&mlon=${hospitalLocation.lng}&zoom=15`;

  return (
    <div className="relative w-full h-full bg-gray-100 rounded-lg overflow-hidden border-2 border-gray-200">
      <iframe
        width="100%"
        height="100%"
        frameBorder="0"
        scrolling="no"
        marginHeight={0}
        marginWidth={0}
        src={mapEmbedUrl}
        className="border-0"
        title="Hospital Location Map"
        allowFullScreen
      />
      <div className="absolute bottom-4 left-4 right-4 flex items-center justify-between">
        <div className="bg-white px-4 py-3 rounded-lg shadow-xl flex items-center space-x-3">
          <MapPin className="w-5 h-5 text-blue-600 flex-shrink-0" />
          <div>
            <p className="font-semibold text-sm">FreshDew Medical Clinic</p>
            <p className="text-xs text-gray-600">135 Cannifton Road, Unit 2 & 3, Belleville, ON K8N 4V4</p>
          </div>
        </div>
        <Button
          asChild
          variant="outline"
          size="sm"
          className="bg-white shadow-xl"
        >
          <a href={mapDirectUrl} target="_blank" rel="noopener noreferrer">
            <ExternalLink className="w-4 h-4 mr-2" />
            Open in Maps
          </a>
        </Button>
      </div>
      <div className="absolute top-2 right-2 text-xs text-gray-500 bg-white/80 px-2 py-1 rounded">
        <a href="https://www.openstreetmap.org/copyright" target="_blank" rel="noopener noreferrer" className="hover:underline">
          © OpenStreetMap
        </a>
      </div>
    </div>
  );
}