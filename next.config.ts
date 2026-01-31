import type { NextConfig } from "next";

const nextConfig: NextConfig = {
  images: {
    remotePatterns: [
      {
        protocol: 'https',
        hostname: 'images.unsplash.com',
      },
      {
        protocol: 'https',
        hostname: 'unsplash.com',
      },
      {
        protocol: 'https',
        hostname: 'media.istockphoto.com',
      },
    ],
    unoptimized: true, // For external images
  },
  // Disable Turbopack to prevent memory issues (use webpack instead)
  // Note: The middleware deprecation warning is informational - middleware.ts still works
  // It will be replaced in future Next.js versions, but for now it's required for Clerk
};

export default nextConfig;
