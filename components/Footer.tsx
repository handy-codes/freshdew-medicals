export default function Footer() {
    return (
      <footer className="bg-gray-900 text-white">
        <div className="container mx-auto px-4 py-8">
          <div className="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div className="py-1">
              <h3 className="text-2xl font-bold mb-4">FreshDew Medical Clinic</h3>
              <p className="text-gray-400">
                Providing world-class healthcare services in Canada.
              </p>
            </div>
            <div>
              <h4 className="text-lg font-semibold mb-4">Quick Links</h4>
              <ul className="space-y-2">
                <li>
                  <a href="/about" className="text-gray-400 hover:text-white">
                    About Us
                  </a>
                </li>
                <li>
                  <a href="/walk-in-clinic" className="text-gray-400 hover:text-white">
                    Walk-in Clinic
                  </a>
                </li>
                <li>
                  <a href="/family-practice" className="text-gray-400 hover:text-white">
                    Family Practice
                  </a>
                </li>
                <li>
                  <a href="/contact" className="text-gray-400 hover:text-white">
                    Contact
                  </a>
                </li>
              </ul>
            </div>
            <div>
              <h4 className="text-lg font-semibold mb-4">Contact Us</h4>
              <address className="text-gray-400 not-italic">
                135 Cannifton Road, Unit 2 & 3<br />
                Belleville, Ontario, K8N 4V4<br />
                Canada<br />
                <br />
                Phone: (613) 243-0110<br />
                Fax: (613) 243-0321<br />
                Email: info@freshdewmedicalclinic.com<br />
                Website: www.freshdewmedicalclinic.com
              </address>
            </div>
            <div>
              <h4 className="text-lg font-semibold mb-4">Follow Us</h4>
              <div className="flex space-x-4">
                {/* Social media links */}
                <a href="#" className="text-gray-400 hover:text-white">
                  Facebook
                </a>
                <a href="#" className="text-gray-400 hover:text-white">
                  Twitter
                </a>
                <a href="#" className="text-gray-400 hover:text-white">
                  LinkedIn
                </a>
              </div>
            </div>
          </div>
          <div className="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
            <p>&copy; {new Date().getFullYear()} FreshDew Medical Clinic. All rights reserved.</p>
          </div>
        </div>
      </footer>
    );
  }