<?php
/**
 * Template Name: About Page
 *
 * @package FreshDewMedical
 */

get_header();
$contact_info = freshdew_get_contact_info();
?>

<section style="padding: 4rem 0; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <h1 style="font-size: 3rem; margin-bottom: 1rem; text-align: center; color: white; text-shadow: 0 2px 10px rgba(0,0,0,0.2);">About FreshDew Medical Clinic</h1>
        <p style="font-size: 1.25rem; text-align: center; opacity: 0.95; max-width: 800px; margin: 0 auto; color: white; text-shadow: 0 1px 5px rgba(0,0,0,0.2);">
            Providing exceptional healthcare services to the Belleville community and surrounding areas.
        </p>
    </div>
</section>

<section style="padding: 4rem 0;">
    <div class="container">
        <div style="max-width: 1200px; margin: 0 auto;">
            <h2 style="font-size: 2.5rem; margin-bottom: 2rem; color: #1f2937;">Our Mission</h2>
            <p style="color: #000000; line-height: 1.8; margin-bottom: 1.5rem; font-size: 1.125rem;">
            Freshdew medical clinic is committed to delivering exceptional patient care to persons of all ages in a warm, welcoming environment.
            </p>
            <p style="color: #000000; line-height: 1.8; margin-bottom: 1.5rem; font-size: 1.125rem;">
             Our Mission is to provide excellent comprehensive medical care in a timely, compassionate, and patient centred manner.
            </p>
            
            <!-- Meet Our Team Section -->
            <h2 style="font-size: 2.5rem; margin: 4rem 0 3rem; color: #1f2937; text-align: center;">Meet Our Team</h2>
            <div style="display: flex; flex-direction: column; gap: 2.5rem; margin-bottom: 4rem;">
                
                <!-- Dr. Joy Kinze Card -->
                <div class="team-card" style="background: white; border-radius: 0.75rem; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: transform 0.3s ease, box-shadow 0.3s ease; display: flex; flex-direction: column;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 12px rgba(0,0,0,0.15)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.1)';">
                    <div class="team-card-image" style="width: 100%; height: 300px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); position: relative; overflow: hidden; border-radius: 0.75rem 0.75rem 0 0; display: flex; align-items: center; justify-content: center;">
                        <?php
                        $doctor1_image = get_template_directory_uri() . '/assets/images/doctors/dr-joy-kinze.jpg';
                        if (file_exists(get_template_directory() . '/assets/images/doctors/dr-joy-kinze.jpg')) {
                            echo '<img src="' . esc_url($doctor1_image) . '" alt="Dr. Joy Kinze" style="width: 100%; height: 100%; object-fit: cover; object-position: center top;">';
                        } else {
                            echo '<div style="width: 100%; height: 100%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem; font-weight: 600;">JK</div>';
                        }
                        ?>
                    </div>
                    <div class="team-card-content" style="padding: 2rem; display: flex; flex-direction: column; width: 100%;">
                        <h3 style="font-size: 1.5rem; font-weight: 700; color: #1f2937; margin-bottom: 0.5rem; width: 100%;">Dr. Joy Kinze</h3>
                        <p style="color: #667eea; font-size: 0.875rem; font-weight: 600; margin-bottom: 1rem; width: 100%;">MBBS, MRCGP, CCFP</p>
                        <p style="color: #000000; line-height: 1.7; margin-bottom: 1.5rem; font-size: 1.125rem; flex-grow: 1; width: 100%;">
                         Dr. Joy Kinze is a UK trained family physician with over a decade of clinical experience and practice. She has worked in low and middle income countries and spent the majority of her practice in rural English town.
                         Her areas of interest are lifestyle medicine and women's health. She is very passionate about healthcare administration having seen the catastrophic consequences when standards are not met in developing countries.
                         She is best described as a compassionate and excellent physician.
                        </p>
                        <a href="https://www.myhealthaccess.ca/branded/freshdew-medical-centre" target="_blank" rel="noopener noreferrer" style="display: block; width: 100%;">
                            <img src="https://www.myhealthaccess.ca/build/branded_signup/book_appt_online_big.png" alt="Book Appointment Online" style="max-width: 100%; height: auto; display: block; width: 100%;">
                        </a>
                    </div>
                </div>
                
                <!-- Dr. Jamal Doe Card -->
                <div class="team-card" style="background: white; border-radius: 0.75rem; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: transform 0.3s ease, box-shadow 0.3s ease; display: flex; flex-direction: column;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 12px rgba(0,0,0,0.15)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.1)';">
                    <div class="team-card-image" style="width: 100%; height: 300px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); position: relative; overflow: hidden; border-radius: 0.75rem 0.75rem 0 0; display: flex; align-items: center; justify-content: center;">
                        <?php
                        $doctor2_image = get_template_directory_uri() . '/assets/images/doctors/dr-jamal-doe.jpg';
                        if (file_exists(get_template_directory() . '/assets/images/doctors/dr-jamal-doe.jpg')) {
                            echo '<img src="' . esc_url($doctor2_image) . '" alt="Dr. Jamal Doe" style="width: 100%; height: 100%; object-fit: cover; object-position: center top;">';
                        } else {
                            echo '<div style="width: 100%; height: 100%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem; font-weight: 600;">JD</div>';
                        }
                        ?>
                    </div>
                    <div class="team-card-content" style="padding: 2rem; display: flex; flex-direction: column; width: 100%;">
                        <h3 style="font-size: 1.5rem; font-weight: 700; color: #1f2937; margin-bottom: 0.5rem; width: 100%;">Dr. Jamal Doe</h3>
                        <p style="color: #667eea; font-size: 0.875rem; font-weight: 600; margin-bottom: 1rem; width: 100%;">MBBS, MPH, MRCSeD, Cert.Med.Edu MRCGP, CCFP</p>
                        <p style="color: #000000; line-height: 1.7; margin-bottom: 1.5rem; font-size: 1.125rem; flex-grow: 1; width: 100%;">
                         Dr Jamal is a surgeon turned family physician. As an associate specialist in Trauma and Orthopaedic surgery, he has performed major  arthroplasties during his surgical training before venturing into family practice where he has been in the last 6 years-and loving it.
                         He holds a Licentiate of the Medical Council of Canada and  Certification in the College of Family Physicians of Canada. He is a Member of the Royal College of Surgeon, Edinburgh, United kingdom, holds Public Health Masters (with merit) from the University of Birmingham and did his Family Practice postgraduate training/residency in the Durham and Tees Valley being among the top 2% of his cohort in the Applied Knowledge Test.
                         He is passionate about Mens health, Public Health Protection, Musculoskeletal Health, Undergraduate and Postgraduate medical education having a Pgcert in Medical Education from the Sunderland University. He is on a pathway to his PhD at the Teesside University, United kingdom.
                        </p>
                        <a href="https://www.myhealthaccess.ca/branded/freshdew-medical-centre" target="_blank" rel="noopener noreferrer" style="display: block; width: 100%;">
                            <img src="https://www.myhealthaccess.ca/build/branded_signup/book_appt_online_big.png" alt="Book Appointment Online" style="max-width: 100%; height: auto; display: block; width: 100%;">
                        </a>
                    </div>
                </div>
                
                <!-- Template Card 1 - Karen Howald -->
                <div class="team-card" style="background: white; border-radius: 0.75rem; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: transform 0.3s ease, box-shadow 0.3s ease; display: flex; flex-direction: column;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 12px rgba(0,0,0,0.15)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.1)';">
                    <div class="team-card-image" style="width: 100%; height: 300px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); position: relative; overflow: hidden; border-radius: 0.75rem 0.75rem 0 0; display: flex; align-items: center; justify-content: center;">
                        <div style="width: 100%; height: 100%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem; font-weight: 600;">KH</div>
                    </div>
                    <div class="team-card-content" style="padding: 2rem; display: flex; flex-direction: column; width: 100%;">
                        <h3 style="font-size: 1.5rem; font-weight: 700; color: #1f2937; margin-bottom: 0.5rem; width: 100%;">Karen Howald</h3>
                        <p style="color: #667eea; font-size: 0.875rem; font-weight: 600; margin-bottom: 1rem; width: 100%;">Medical Office Assistant</p>
                        <p style="color: #000000; line-height: 1.7; margin-bottom: 1.5rem; font-size: 1.125rem; flex-grow: 1; width: 100%;">
                         With many years of experience in patient care, Karen is committed to delivering compassionate, efficient, and detail-oriented service. She prides in supporting others and creating a positive experience for every person she works with. Outside of work, she enjoys reading, the arts, and baking—especially carrot cake—and she shares her home with two cats. Karen is also a proud parent of a successful son and brings that same dedication and care to her professional life.
                        </p>
                        <a href="https://www.myhealthaccess.ca/branded/freshdew-medical-centre" target="_blank" rel="noopener noreferrer" style="display: block; width: 100%;">
                            <img src="https://www.myhealthaccess.ca/build/branded_signup/book_appt_online_big.png" alt="Book Appointment Online" style="max-width: 100%; height: auto; display: block; width: 100%;">
                        </a>
                    </div>
                </div>
                
                <!-- Template Card 2 - Emeka Owo -->
                <div class="team-card emeka-owo-card" style="background: white; border-radius: 0.75rem; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: transform 0.3s ease, box-shadow 0.3s ease; display: flex; flex-direction: column;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 12px rgba(0,0,0,0.15)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.1)';">
                    <div class="team-card-image" style="width: 100%; height: 300px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); position: relative; overflow: hidden; border-radius: 0.75rem 0.75rem 0 0; display: flex; align-items: center; justify-content: center;">
                        <div style="width: 100%; height: 100%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem; font-weight: 600;">EO</div>
                    </div>
                    <div class="team-card-content" style="padding: 2rem; display: flex; flex-direction: column; width: 100%;">
                        <h3 style="font-size: 1.5rem; font-weight: 700; color: #1f2937; margin-bottom: 0.5rem; width: 100%;">Emeka Owo</h3>
                        <p style="color: #667eea; font-size: 0.875rem; font-weight: 600; margin-bottom: 1rem; width: 100%;">Healthcare Technology Developer</p>
                        <p style="color: #000000; line-height: 1.7; margin-bottom: 1.5rem; font-size: 1.125rem; flex-grow: 1; width: 100%;">
                        Emeka Owo is a Healthcare Technology Developer with years of experience designing and implementing secure, high-performance systems for clinical settings. He brings deep expertise in health information systems, telemedicine integration, clinical workflow optimization, and healthcare data protection. His core strengths include building secure cloud infrastructures, developing scalable application architectures, and ensuring compliance-driven data management for modern medical practices.  
                        </p>
                        <p style="color: #000000; line-height: 1.7; margin-bottom: 1.5rem; font-size: 1.125rem; flex-grow: 1; width: 100%;">
                         Emeka’s work focuses on advancing care delivery through resilient digital solutions that enhance operational efficiency and safeguard patient information. Outside of work, he maintains a keen interest in global affairs and practices strategic chess to refine his analytical thinking.
                        </p>
                        <a href="https://www.myhealthaccess.ca/branded/freshdew-medical-centre" target="_blank" rel="noopener noreferrer" style="display: block; width: 100%;">
                            <img src="https://www.myhealthaccess.ca/build/branded_signup/book_appt_online_big.png" alt="Book Appointment Online" style="max-width: 100%; height: auto; display: block; width: 100%;">
                        </a>
                    </div>
                </div>
                
            </div>
            
            <h2 style="font-size: 2.5rem; margin: 3rem 0 2rem; color: #1f2937;">Our Services</h2>
            <ul style="color: #000000; line-height: 2; font-size: 1.125rem; list-style: none; padding: 0;">
                <li style="margin-bottom: 1rem; padding-left: 2rem; position: relative;">
                    <span style="position: absolute; left: 0; color: #2563eb;">✓</span>
                    <strong>Walk-in Clinic:</strong> No appointment needed. Quality medical care when you need it.
                </li>
                <li style="margin-bottom: 1rem; padding-left: 2rem; position: relative;">
                    <span style="position: absolute; left: 0; color: #2563eb;">✓</span>
                    <strong>Family Practice:</strong> Comprehensive family healthcare with dedicated family doctors.
                </li>
                <li style="margin-bottom: 1rem; padding-left: 2rem; position: relative;">
                    <span style="position: absolute; left: 0; color: #2563eb;">✓</span>
                    <strong>Telehealth:</strong> Virtual consultations from the comfort of your home.
                </li>
            </ul>
        </div>
    </div>
</section>

<?php
get_footer();



