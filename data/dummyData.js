/**
 * Hospital Management System (HMS) - Dummy Data
 * Realistic sample data structured for clean future migration to PHP/MySQL backend.
 */

const INITIAL_DUMMY_DATA = {
  patients: [
    {
      id: "H1268",
      name: "Sneha R",
      age: 28,
      dob: "1998-05-14",
      gender: "Female",
      phone: "+91 98450 12345",
      email: "sneha.r@example.com",
      address: "42nd Cross, 7th Block, Jayanagar, Bengaluru",
      bloodGroup: "O+",
      emergencyContact: "Ramesh R (Father) - +91 98450 99999",
      medicalHistory: "Allergies: Penicillin (Mild rash). Regular vitamins.",
      status: "Active",
      registeredDate: "2026-09-10"
    },
    {
      id: "H1042",
      name: "Rahul K",
      age: 42,
      dob: "1984-02-18",
      gender: "Male",
      phone: "+91 98765 43210",
      email: "rahul.k@example.com",
      address: "15 Palm Meadows, Indiranagar, Bengaluru",
      bloodGroup: "B+",
      emergencyContact: "Anita K (Wife) - +91 98765 43211",
      medicalHistory: "History of seasonal bronchitis. Non-smoker.",
      status: "Active",
      registeredDate: "2026-09-01"
    },
    {
      id: "H1105",
      name: "Ananya P",
      age: 31,
      dob: "1995-11-20",
      gender: "Female",
      phone: "+91 99887 76655",
      email: "ananya.p@example.com",
      address: "88 Silver Oak Lane, Koramangala, Bengaluru",
      bloodGroup: "A+",
      emergencyContact: "Deepak P (Spouse) - +91 99887 76656",
      medicalHistory: "No prior chronic illnesses or known drug allergies.",
      status: "Active",
      registeredDate: "2026-09-05"
    },
    {
      id: "H1278",
      name: "chandanap",
      age: 23,
      dob: "2003-05-14",
      gender: "Female",
      phone: "+91 98450 12345",
      email: "chandanap.murthy@gmail.com",
      address: "Bangalore, Karnataka",
      bloodGroup: "A+",
      emergencyContact: "Family - +91 98450 99999",
      medicalHistory: "Healthy. No known drug allergies.",
      status: "Active",
      registeredDate: "2026-09-18"
    },
    {
      id: "PAT-2026-001",
      name: "Robert Harrison",
      age: 48,
      dob: "1978-04-15",
      gender: "Male",
      phone: "+1 (555) 234-5678",
      email: "robert.harrison@example.com",
      address: "742 Evergreen Terrace, Springfield",
      bloodGroup: "O+",
      emergencyContact: "Emily Harrison (Wife) - +1 (555) 234-5679",
      medicalHistory: "Hypertension diagnosed in 2021. No known drug allergies. Mild asthma in childhood.",
      status: "Active",
      registeredDate: "2026-01-10"
    },
    {
      id: "PAT-2026-002",
      name: "Sophia Martinez",
      age: 34,
      dob: "1992-08-22",
      gender: "Female",
      phone: "+1 (555) 345-6789",
      email: "sophia.martinez@example.com",
      address: "128 Oak Ridge Lane, Riverdale",
      bloodGroup: "A+",
      emergencyContact: "Carlos Martinez (Brother) - +1 (555) 345-6780",
      medicalHistory: "Allergic to Penicillin. Appendectomy in 2018.",
      status: "Active",
      registeredDate: "2026-01-18"
    },
    {
      id: "PAT-2026-003",
      name: "David Chen",
      age: 62,
      dob: "1964-11-03",
      gender: "Male",
      phone: "+1 (555) 456-7890",
      email: "david.chen@example.com",
      address: "45 Lotus Grove, Metro City",
      bloodGroup: "B+",
      emergencyContact: "Linda Chen (Daughter) - +1 (555) 456-7891",
      medicalHistory: "Type 2 Diabetes (HbA1c 7.1%). Chronic lower back pain. Takes Metformin 500mg.",
      status: "Active",
      registeredDate: "2026-02-05"
    },
    {
      id: "PAT-2026-004",
      name: "Emma Watson",
      age: 29,
      dob: "1997-03-19",
      gender: "Female",
      phone: "+1 (555) 567-8901",
      email: "emma.watson@example.com",
      address: "89 Pine Crest Ave, Sunnyside",
      bloodGroup: "AB-",
      emergencyContact: "Arthur Watson (Father) - +1 (555) 567-8902",
      medicalHistory: "Seasonal allergic rhinitis. No prior surgeries.",
      status: "Active",
      registeredDate: "2026-02-14"
    },
    {
      id: "PAT-2026-005",
      name: "James Wilson",
      age: 55,
      dob: "1971-06-30",
      gender: "Male",
      phone: "+1 (555) 678-9012",
      email: "james.wilson@example.com",
      address: "310 Meadowbrook Rd, Lakewood",
      bloodGroup: "O-",
      emergencyContact: "Sarah Wilson (Wife) - +1 (555) 678-9013",
      medicalHistory: "Coronary artery disease, stent placed in 2022. Takes Aspirin & Atorvastatin.",
      status: "Active",
      registeredDate: "2026-02-20"
    },
    {
      id: "PAT-2026-006",
      name: "Aaliyah Patel",
      age: 26,
      dob: "2000-09-12",
      gender: "Female",
      phone: "+1 (555) 789-0123",
      email: "aaliyah.patel@example.com",
      address: "512 Highland Blvd, Fairview",
      bloodGroup: "A-",
      emergencyContact: "Karan Patel (Spouse) - +1 (555) 789-0124",
      medicalHistory: "Migraine with aura. Allergic to sulfa drugs.",
      status: "Active",
      registeredDate: "2026-03-01"
    }
  ],

  doctors: [
    {
      id: "DOC-101",
      name: "Dr. Sarah Jenkins",
      specialization: "Cardiology",
      qualification: "MD, FACC - Harvard Medical School",
      experience: "14 Years",
      phone: "+1 (555) 111-2233",
      email: "dr.jenkins@medpulse-hms.com",
      room: "Consultation Room 302 (Cardio Wing)",
      availability: "Available",
      status: "Active",
      schedule: "Mon - Fri: 09:00 AM - 02:00 PM",
      avatar: "https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&q=80&w=256"
    },
    {
      id: "DOC-102",
      name: "Dr. Marcus Vance",
      specialization: "Neurology",
      qualification: "MD, PhD - Johns Hopkins",
      experience: "18 Years",
      phone: "+1 (555) 222-3344",
      email: "dr.vance@medpulse-hms.com",
      room: "Consultation Room 405 (Neuro Center)",
      availability: "Available",
      status: "Active",
      schedule: "Mon, Wed, Fri: 10:00 AM - 04:00 PM",
      avatar: "https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&q=80&w=256"
    },
    {
      id: "DOC-103",
      name: "Dr. Elena Rostova",
      specialization: "Pediatrics",
      qualification: "MD, FAAP - Stanford University",
      experience: "9 Years",
      phone: "+1 (555) 333-4455",
      email: "dr.rostova@medpulse-hms.com",
      room: "Pediatric Clinic Room 108",
      availability: "In Surgery",
      status: "Active",
      schedule: "Tue - Sat: 08:30 AM - 01:30 PM",
      avatar: "https://images.unsplash.com/photo-1622902046580-2b47f47f5471?auto=format&fit=crop&q=80&w=256"
    },
    {
      id: "DOC-104",
      name: "Dr. Gregory Hayes",
      specialization: "Orthopedics",
      qualification: "MS (Ortho), MCh - Mayo Clinic",
      experience: "16 Years",
      phone: "+1 (555) 444-5566",
      email: "dr.hayes@medpulse-hms.com",
      room: "Orthopedic Suite 210",
      availability: "On Leave",
      status: "Active",
      schedule: "Mon - Thu: 11:00 AM - 05:00 PM",
      avatar: "https://images.unsplash.com/photo-1537368910025-700350fe46c7?auto=format&fit=crop&q=80&w=256"
    },
    {
      id: "DOC-105",
      name: "Dr. Priya Sharma",
      specialization: "General Medicine",
      qualification: "MBBS, MD (Internal Medicine)",
      experience: "11 Years",
      phone: "+1 (555) 555-6677",
      email: "dr.sharma@medpulse-hms.com",
      room: "OPD Room 102",
      availability: "Available",
      status: "Active",
      schedule: "Mon - Sat: 09:00 AM - 05:00 PM",
      avatar: "https://images.unsplash.com/photo-1651008376811-b90baee60c1f?auto=format&fit=crop&q=80&w=256"
    }
  ],

  appointments: [
    {
      id: "APT-2026-101",
      patientId: "PAT-2026-001",
      patientName: "Robert Harrison",
      doctorId: "DOC-101",
      doctorName: "Dr. Sarah Jenkins",
      department: "Cardiology",
      date: "2026-09-16",
      time: "09:30 AM",
      reason: "Routine cardiac follow-up and blood pressure assessment",
      status: "In Consultation",
      checkInTime: "09:18 AM"
    },
    {
      id: "APT-2026-102",
      patientId: "PAT-2026-002",
      patientName: "Sophia Martinez",
      doctorId: "DOC-105",
      doctorName: "Dr. Priya Sharma",
      department: "General Medicine",
      date: "2026-09-16",
      time: "10:15 AM",
      reason: "Recurring tension headaches and fatigue",
      status: "Waiting",
      checkInTime: "09:55 AM"
    },
    {
      id: "APT-2026-103",
      patientId: "PAT-2026-003",
      patientName: "David Chen",
      doctorId: "DOC-101",
      doctorName: "Dr. Sarah Jenkins",
      department: "Cardiology",
      date: "2026-09-16",
      time: "11:00 AM",
      reason: "ECG review and diabetes medication review",
      status: "Confirmed",
      checkInTime: null
    },
    {
      id: "APT-2026-104",
      patientId: "PAT-2026-004",
      patientName: "Emma Watson",
      doctorId: "DOC-102",
      doctorName: "Dr. Marcus Vance",
      department: "Neurology",
      date: "2026-09-16",
      time: "11:45 AM",
      reason: "Post-concussion syndrome follow-up",
      status: "Confirmed",
      checkInTime: null
    },
    {
      id: "APT-2026-105",
      patientId: "PAT-2026-005",
      patientName: "James Wilson",
      doctorId: "DOC-104",
      doctorName: "Dr. Gregory Hayes",
      department: "Orthopedics",
      date: "2026-09-17",
      time: "02:00 PM",
      reason: "Right knee arthroscopy follow-up",
      status: "Confirmed",
      checkInTime: null
    },
    {
      id: "APT-2026-106",
      patientId: "PAT-2026-006",
      patientName: "Aaliyah Patel",
      doctorId: "DOC-105",
      doctorName: "Dr. Priya Sharma",
      department: "General Medicine",
      date: "2026-09-15",
      time: "03:30 PM",
      reason: "Seasonal allergy flare-up and wheezing",
      status: "Completed",
      checkInTime: "03:15 PM"
    }
  ],

  consultations: [
    {
      id: "CON-H1268",
      patientId: "H1268",
      patientName: "Sneha R",
      doctorId: "DOC-01",
      doctorName: "Dr. Priya S",
      date: "2026-09-16",
      symptoms: "Mild fever (100.2°F), headache, fatigue and seasonal viral malaise.",
      diagnosis: "Acute Upper Respiratory Tract Infection & Mild Dehydration.",
      notes: "Adequate hydration advised. Blood vitals normal. Review in 5 days if fever persists.",
      tests: [
        { name: "Complete Blood Count (CBC)", result: "WBC 7,800/mcL, Platelets 240,000", date: "2026-09-16", remarks: "Normal reference parameters" },
        { name: "Widal Agglutination Slide Test", result: "Negative for S. Typhi (Non-reactive)", date: "2026-09-16", remarks: "Normal" }
      ],
      prescriptions: [
        { medicine: "Paracetamol", dosage: "500 mg", frequency: "1-0-1 (Twice Daily)", duration: "5 Days", instructions: "Take after food with water" },
        { medicine: "Vitamin D3", dosage: "60k IU", frequency: "Once a week", duration: "4 Weeks", instructions: "Take after milk" },
        { medicine: "Calcium Carbonate", dosage: "500 mg", frequency: "1-0-0 (Once Daily)", duration: "15 Days", instructions: "Take after breakfast" }
      ]
    },
    {
      id: "CON-2026-001",
      patientId: "PAT-2026-001",
      patientName: "Robert Harrison",
      doctorId: "DOC-101",
      doctorName: "Dr. Sarah Jenkins",
      date: "2026-09-16",
      symptoms: "Mild chest tightness upon brisk walking, morning dizziness.",
      diagnosis: "Stage 2 Essential Hypertension with mild exertional angina.",
      notes: "Patient advised to reduce sodium intake. BP recorded at 145/92 mmHg today. Recommended daily 20-min gentle walks.",
      tests: [
        { name: "Electrocardiogram (ECG - 12 Lead)", result: "Normal sinus rhythm, mild LVH signs", date: "2026-09-16", remarks: "Stable compared to 2025" },
        { name: "Lipid Profile Panel", result: "Total Cholesterol 215 mg/dL, LDL 135 mg/dL", date: "2026-09-16", remarks: "Statin dosage slightly adjusted" }
      ],
      prescriptions: [
        { medicine: "Amlodipine Besylate", dosage: "5 mg", frequency: "1-0-0 (Morning)", duration: "30 Days", instructions: "Take with or without food after breakfast" },
        { medicine: "Atorvastatin Calcium", dosage: "20 mg", frequency: "0-0-1 (Night)", duration: "30 Days", instructions: "Take at bedtime with water" },
        { medicine: "Aspirin (Enteric Coated)", dosage: "75 mg", frequency: "1-0-0 (Morning)", duration: "30 Days", instructions: "Take with water immediately after food" }
      ]
    },
    {
      id: "CON-2026-002",
      patientId: "PAT-2026-006",
      patientName: "Aaliyah Patel",
      doctorId: "DOC-105",
      doctorName: "Dr. Priya Sharma",
      date: "2026-09-15",
      symptoms: "Sneezing, nasal congestion, ocular itching, nocturnal dry cough.",
      diagnosis: "Allergic Rhinitis and Mild Reactive Airway Disease.",
      notes: "Avoid dust mites and pet dander. Use HEPA air purifier at home.",
      tests: [
        { name: "Complete Blood Count (CBC)", result: "Eosinophils 8.2% (Elevated)", date: "2026-09-15", remarks: "Allergic profile" }
      ],
      prescriptions: [
        { medicine: "Levocetirizine Dihydrochloride", dosage: "5 mg", frequency: "0-0-1 (Night)", duration: "14 Days", instructions: "Take at bedtime" },
        { medicine: "Fluticasone Furoate Nasal Spray", dosage: "27.5 mcg/spray", frequency: "2 sprays/nostril once daily", duration: "30 Days", instructions: "Prime bottle before first use" }
      ]
    }
  ],

  bills: [
    {
      billId: "INV-2026-H1278",
      patientId: "H1278",
      patientName: "chandanap",
      date: "2026-09-18",
      doctorName: "Dr. Ananya Sharma",
      consultationFee: 500.00,
      testCharges: 900.00,
      medicineCharges: 155.00,
      otherCharges: 0.00,
      totalAmount: 1555.00,
      paymentStatus: "Paid",
      paymentMethod: "UPI / Online Settlement"
    },
    {
      billId: "INV-2026-H1268",
      patientId: "H1268",
      patientName: "Sneha R",
      date: "2026-09-16",
      doctorName: "Dr. Priya S",
      consultationFee: 500.00,
      testCharges: 800.00,
      medicineCharges: 450.00,
      otherCharges: 0.00,
      totalAmount: 1750.00,
      paymentStatus: "Paid",
      paymentMethod: "UPI / Net Banking"
    },
    {
      billId: "INV-2026-0881",
      patientId: "PAT-2026-001",
      patientName: "Robert Harrison",
      date: "2026-09-16",
      doctorName: "Dr. Sarah Jenkins",
      consultationFee: 120.00,
      testCharges: 180.00,
      medicineCharges: 65.50,
      otherCharges: 15.00,
      totalAmount: 380.50,
      paymentStatus: "Pending",
      paymentMethod: "Insurance Pending"
    },
    {
      billId: "INV-2026-0880",
      patientId: "PAT-2026-006",
      patientName: "Aaliyah Patel",
      date: "2026-09-15",
      doctorName: "Dr. Priya Sharma",
      consultationFee: 80.00,
      testCharges: 60.00,
      medicineCharges: 42.00,
      otherCharges: 10.00,
      totalAmount: 192.00,
      paymentStatus: "Paid",
      paymentMethod: "Credit Card (Visa ending 4128)"
    },
    {
      billId: "INV-2026-0879",
      patientId: "PAT-2026-003",
      patientName: "David Chen",
      date: "2026-09-10",
      doctorName: "Dr. Sarah Jenkins",
      consultationFee: 120.00,
      testCharges: 110.00,
      medicineCharges: 55.00,
      otherCharges: 0.00,
      totalAmount: 285.00,
      paymentStatus: "Paid",
      paymentMethod: "Cash"
    },
    {
      billId: "INV-2026-0878",
      patientId: "PAT-2026-005",
      patientName: "James Wilson",
      date: "2026-09-08",
      doctorName: "Dr. Gregory Hayes",
      consultationFee: 150.00,
      testCharges: 320.00,
      medicineCharges: 110.00,
      otherCharges: 45.00,
      totalAmount: 625.00,
      paymentStatus: "Paid",
      paymentMethod: "Medicare Co-pay"
    }
  ],

  ratings: [
    {
      id: "REV-H1105",
      patientName: "Ananya P",
      doctorId: "DOC-01",
      doctorName: "Dr. Priya S",
      department: "Cardiology",
      rating: 5,
      comment: "Dr. Priya S was very patient and explained the diagnosis in detail. Clinic is very clean, prompt and well maintained.",
      date: "2026-09-15",
      verified: true
    },
    {
      id: "REV-101",
      patientName: "Robert Harrison",
      doctorId: "DOC-101",
      doctorName: "Dr. Sarah Jenkins",
      department: "Cardiology",
      rating: 5,
      comment: "Dr. Jenkins was extremely thorough, explained my ECG clearly and answered all my questions patiently. Staff was very helpful.",
      date: "2026-09-14",
      verified: true
    },
    {
      id: "REV-102",
      patientName: "Sophia Martinez",
      doctorId: "DOC-105",
      doctorName: "Dr. Priya Sharma",
      department: "General Medicine",
      rating: 4,
      comment: "Great consultation, quick diagnosis. The waiting room was slightly crowded, but overall excellent care.",
      date: "2026-09-12",
      verified: true
    },
    {
      id: "REV-103",
      patientName: "Emma Watson",
      doctorId: "DOC-102",
      doctorName: "Dr. Marcus Vance",
      department: "Neurology",
      rating: 5,
      comment: "Top notch neurology department. Dr. Vance takes genuine care and gives clear treatment pathways.",
      date: "2026-09-05",
      verified: true
    },
    {
      id: "REV-104",
      patientName: "James Wilson",
      doctorId: "DOC-104",
      doctorName: "Dr. Gregory Hayes",
      department: "Orthopedics",
      rating: 5,
      comment: "Knee rehabilitation post-surgery has been smooth thanks to Dr. Hayes and the physio team.",
      date: "2026-08-28",
      verified: true
    }
  ],

  healthCheckups: [
    {
      id: "CHK-2026-01",
      patientName: "David Chen",
      patientId: "PAT-2026-003",
      package: "Comprehensive Cardiac & Diabetic Checkup",
      date: "2026-09-10",
      bp: "135/85 mmHg",
      bmi: "27.4",
      glucoseFasting: "128 mg/dL",
      cholesterol: "210 mg/dL",
      heartRate: "74 bpm",
      status: "Completed",
      findings: "Fasting glucose elevated. Cholesterol borderline high. Advised lifestyle changes and diet counseling."
    },
    {
      id: "CHK-2026-02",
      patientName: "Emma Watson",
      patientId: "PAT-2026-004",
      package: "Executive Annual Wellness Screening",
      date: "2026-08-20",
      bp: "115/75 mmHg",
      bmi: "21.6",
      glucoseFasting: "88 mg/dL",
      cholesterol: "172 mg/dL",
      heartRate: "68 bpm",
      status: "Completed",
      findings: "All major vital parameters within ideal reference ranges. High overall wellness score."
    },
    {
      id: "CHK-2026-03",
      patientName: "Robert Harrison",
      patientId: "PAT-2026-001",
      package: "Senior Heart & Vascular Assessment",
      date: "2026-09-22",
      bp: "Upcoming",
      bmi: "26.1",
      glucoseFasting: "--",
      cholesterol: "--",
      heartRate: "--",
      status: "Scheduled",
      findings: "Pre-checkup fasting instructions issued."
    }
  ],

  dischargeSummaries: [
    {
      id: "DS-H1042",
      patientId: "H1042",
      patientName: "Rahul K",
      age: 42,
      gender: "Male",
      admissionDate: "2026-09-10",
      dischargeDate: "2026-09-14",
      doctor: "Dr. Priya S (Cardiology & Internal Med)",
      diagnosis: "Acute Bronchial Spasm & Lower Respiratory Tract Infection",
      treatment: "Nebulization with Budesonide, IV Ceftriaxone 1g BD, Oral Bronchodilators.",
      conditionAtDischarge: "Afebrile, Hemodynamically stable, Chest clear on auscultation, SpO2 98% on room air.",
      medicines: [
        "Levosalbutamol Inhaler (2 puffs as needed)",
        "Amoxicillin + Clavulanate 625mg twice daily for 5 days",
        "Montelukast 10mg once daily at bedtime for 14 days"
      ],
      testsPerformed: "Chest X-Ray (PA View), Complete Blood Count, Sputum Microscopy",
      doctorNotes: "Avoid exposure to dust, sudden cold air, and allergens. Continue steam inhalation twice daily for 5 days.",
      followUpInstructions: "Follow-up review in OPD Suite 102 on 2026-09-24 or earlier if breathing difficulty returns."
    },
    {
      id: "DS-2026-042",
      patientId: "PAT-2026-005",
      patientName: "James Wilson",
      age: 55,
      gender: "Male",
      admissionDate: "2026-09-02",
      dischargeDate: "2026-09-06",
      doctor: "Dr. Gregory Hayes (Orthopedics)",
      diagnosis: "Right Knee Degenerative Meniscal Tear & Moderate Osteoarthritis",
      treatment: "Right Arthroscopic Partial Meniscectomy under general anesthesia. Intra-articular bupivacaine.",
      conditionAtDischarge: "Hemodynamically stable, wound clean and dry, ambulating with walker support.",
      medicines: [
        "Celecoxib 200mg once daily for 7 days (post meals)",
        "Acetaminophen 500mg as needed for moderate pain",
        "Enoxaparin 40mg SC daily for 5 days (DVT prophylaxis)"
      ],
      testsPerformed: "Pre-op Right Knee MRI, Pre-op Blood panel, Post-op Knee Radiograph",
      doctorNotes: "Keep surgical knee elevated when resting. Ice pack application 20 minutes thrice daily. Physiotherapy home exercises initiated.",
      followUpInstructions: "Remove dressing and suture check in OPD Suite 210 on 2026-09-17 at 02:00 PM."
    },
    {
      id: "DS-2026-041",
      patientId: "PAT-2026-002",
      patientName: "Sophia Martinez",
      age: 34,
      gender: "Female",
      admissionDate: "2026-08-14",
      dischargeDate: "2026-08-17",
      doctor: "Dr. Priya Sharma (Internal Medicine)",
      diagnosis: "Acute Dehydration Secondary to Gastroenteritis, Hypokalemia resolved",
      treatment: "Intravenous fluid rehydration (Normal Saline & Ringers Lactate), antiemetics, potassium supplementation.",
      conditionAtDischarge: "Afebrile, tolerating oral diet well, electrolytes normalized.",
      medicines: [
        "Oral Rehydration Salts (ORS) as required",
        "Probiotics capsule once daily for 10 days"
      ],
      testsPerformed: "Serum Electrolytes, Stool Culture, Ultrasound Abdomen",
      doctorNotes: "Hydrate adequately with coconut water and clear broths. Avoid spicy or unpasteurized food for 2 weeks.",
      followUpInstructions: "Follow up in OPD after 10 days or immediately if vomiting recurs."
    }
  ],

  documents: [
    {
      id: "DOC-FILE-001",
      name: "Chest_XRay_Digital_RobertHarrison.pdf",
      category: "Medical Reports",
      uploadedDate: "2026-09-14",
      uploadedBy: "Dr. Sarah Jenkins",
      fileType: "PDF",
      fileSize: "2.4 MB",
      status: "Verified"
    },
    {
      id: "DOC-FILE-002",
      name: "Discharge_Summary_JamesWilson_DS-042.pdf",
      category: "Discharge Documents",
      uploadedDate: "2026-09-06",
      uploadedBy: "Reception Desk (Nurse Karen)",
      fileType: "PDF",
      fileSize: "1.1 MB",
      status: "Finalized"
    },
    {
      id: "DOC-FILE-003",
      name: "Blood_Chemistry_Panel_DavidChen.pdf",
      category: "Medical Reports",
      uploadedDate: "2026-09-10",
      uploadedBy: "Central Pathology Lab",
      fileType: "PDF",
      fileSize: "850 KB",
      status: "Verified"
    },
    {
      id: "DOC-FILE-004",
      name: "Health_Insurance_PreAuth_Card.jpg",
      category: "Patient Documents",
      uploadedDate: "2026-09-01",
      uploadedBy: "Robert Harrison",
      fileType: "JPG",
      fileSize: "1.8 MB",
      status: "Approved"
    },
    {
      id: "DOC-FILE-005",
      name: "Hospital_Infection_Control_Protocol_2026.pdf",
      category: "Hospital Documents",
      uploadedDate: "2026-01-15",
      uploadedBy: "Admin / Hospital Board",
      fileType: "PDF",
      fileSize: "4.6 MB",
      status: "Published"
    }
  ],

  waitingQueue: [
    {
      id: "WQ-01",
      patientName: "Robert Harrison",
      patientId: "PAT-2026-001",
      doctorName: "Dr. Sarah Jenkins",
      department: "Cardiology",
      appointmentTime: "09:30 AM",
      checkInTime: "09:18 AM",
      waitMinutes: 12,
      status: "In Consultation"
    },
    {
      id: "WQ-02",
      patientName: "Sophia Martinez",
      patientId: "PAT-2026-002",
      doctorName: "Dr. Priya Sharma",
      department: "General Medicine",
      appointmentTime: "10:15 AM",
      checkInTime: "09:55 AM",
      waitMinutes: 20,
      status: "Waiting"
    },
    {
      id: "WQ-03",
      patientName: "David Chen",
      patientId: "PAT-2026-003",
      doctorName: "Dr. Sarah Jenkins",
      department: "Cardiology",
      appointmentTime: "11:00 AM",
      checkInTime: "10:35 AM",
      waitMinutes: 25,
      status: "Waiting"
    },
    {
      id: "WQ-04",
      patientName: "Aaliyah Patel",
      patientId: "PAT-2026-006",
      doctorName: "Dr. Priya Sharma",
      department: "General Medicine",
      appointmentTime: "09:00 AM",
      checkInTime: "08:50 AM",
      waitMinutes: 10,
      status: "Completed"
    }
  ],

  assets: [
    {
      id: "AST-ECG",
      assetId: "EQ-ECG-102",
      name: "ECG Machine (12-Lead Digital)",
      category: "Biomedical",
      location: "Room 102 (OPD)",
      status: "Working",
      purchaseDate: "2024-05-12",
      maintenanceDate: "2026-08-15",
      cost: "₹1,45,000"
    },
    {
      id: "AST-XRAY",
      assetId: "EQ-RAD-01",
      name: "Digital X-Ray Unit",
      category: "Radiology",
      location: "Radiology Bay 1",
      status: "Working",
      purchaseDate: "2023-11-20",
      maintenanceDate: "2026-09-02",
      cost: "₹18,50,000"
    },
    {
      id: "AST-WC",
      assetId: "EQ-MOB-08",
      name: "Transport Wheelchair",
      category: "Mobility",
      location: "Ground Floor Lobby",
      status: "Working",
      purchaseDate: "2025-02-10",
      maintenanceDate: "2026-07-10",
      cost: "₹14,000"
    },
    {
      id: "AST-BED",
      assetId: "EQ-FUR-3B",
      name: "Semi-Fowler Hospital Bed",
      category: "Ward & Furniture",
      location: "Ward 3B (Room 304)",
      status: "Working",
      purchaseDate: "2024-08-01",
      maintenanceDate: "2026-06-20",
      cost: "₹42,000"
    },
    {
      id: "AST-AC",
      assetId: "EQ-HVAC-01",
      name: "Cleanroom Air Conditioner & HEPA Filter",
      category: "HVAC & Facilities",
      location: "Operation Theater 1",
      status: "Working",
      purchaseDate: "2024-01-15",
      maintenanceDate: "2026-09-05",
      cost: "₹95,000"
    },
    {
      id: "AST-01",
      assetId: "EQ-BIO-201",
      name: "Philips HeartStart XL+ Defibrillator",
      category: "Biomedical",
      location: "Emergency Trauma Bay 2",
      status: "Working",
      purchaseDate: "2024-03-15",
      maintenanceDate: "2026-08-10",
      cost: "$12,500"
    },
    {
      id: "AST-02",
      assetId: "EQ-RAD-105",
      name: "GE Healthcare Optima CT Scanner",
      category: "Biomedical",
      location: "Radiology Wing - Room B12",
      status: "Working",
      purchaseDate: "2023-07-20",
      maintenanceDate: "2026-09-01",
      cost: "$280,000"
    },
    {
      id: "AST-03",
      assetId: "EQ-SUR-310",
      name: "Stryker Laparoscopy 1688 AIM 4K Tower",
      category: "Surgical Instruments",
      location: "Operation Theater 3",
      status: "Maintenance",
      purchaseDate: "2025-01-11",
      maintenanceDate: "2026-09-14",
      cost: "$65,000"
    },
    {
      id: "AST-04",
      assetId: "EQ-IT-084",
      name: "Dell PowerEdge R750 EMR Database Server",
      category: "IT Equipment",
      location: "Server Room 101",
      status: "Working",
      purchaseDate: "2024-11-05",
      maintenanceDate: "2026-06-12",
      cost: "$18,200"
    },
    {
      id: "AST-05",
      assetId: "EQ-FUR-502",
      name: "Hill-Rom Progressa ICU Smart Bed",
      category: "Furniture & Ward",
      location: "Intensive Care Unit Bed 04",
      status: "Working",
      purchaseDate: "2024-05-18",
      maintenanceDate: "2026-07-25",
      cost: "$8,900"
    },
    {
      id: "AST-06",
      assetId: "EQ-BIO-219",
      name: "Mindray BeneView T8 Patient Monitor",
      category: "Biomedical",
      location: "Cardio Recovery Unit",
      status: "Not Available",
      purchaseDate: "2023-09-14",
      maintenanceDate: "2026-09-15",
      cost: "$7,400"
    }
  ]
};

// Export for use in browser global or module environment
if (typeof window !== 'undefined') {
  window.INITIAL_DUMMY_DATA = INITIAL_DUMMY_DATA;
}
