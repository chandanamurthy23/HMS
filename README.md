# Hospital Management System (HMS)

A modern, responsive, and comprehensive Hospital Management System (HMS) frontend built with clean architectural standards, modular JavaScript state management, and contemporary medical-grade aesthetics.

---

## Live Demo & Pages

| # | Screen / Feature | Description | File Path |
|---|---|---|---|
| **1** | **Public Hospital Homepage (Landing Page)** | Root landing page with emergency bar, hero banner, quick access tiles, metrics, live chart, and offcanvas mobile menu. | `index.html` (or `home.html`) |
| **2** | **Login Portal (Role Based)** | Split-card authentication with role switcher, password visibility toggle, and responsive medical banner. | `login.html` |
| **3** | **Clinical Departments** | 8 specialized medical divisions, HOD faculty cards, bed capacity, real-time search & category filter, and modal for adding new departments. | `pages/departments.html` |
| **4** | **Admin Dashboard** | Executive summary cards, monthly Outpatient/Inpatient visits trend chart, and department-wise doughnut chart. | `pages/admin/dashboard.html` |
| **5** | **Receptionist Dashboard** | Daily appointments counter, interactive monthly calendar with active date picker, and quick booking modal. | `pages/receptionist/dashboard.html` |
| **6** | **Doctor Dashboard** | Specialist schedule, OPD availability status toggle, and patient consultation queue. | `pages/doctor/dashboard.html` |
| **7** | **Patient Dashboard** | Personal medical summary, upcoming visits, prescription downloads, and bill payment portal. | `pages/patient/dashboard.html` |
| **8** | **Patient Registration** | 3-step vertical wizard stepper (Personal, Contact, Medical History), auto-generated Patient ID, and searchable patient directory. | `pages/patients.html` |
| **9** | **Appointment Booking** | 3-step horizontal wizard (Select Doctor -> Date & Time Slot -> Confirm) with fee calculations. | `pages/appointments.html` |
| **10** | **Doctor Directory & Schedule** | Weekly doctor duty roster, room allocations, specialization search, and doctor profile cards. | `pages/doctors.html` |
| **11** | **Consultation Suite** | Patient clinical header, diagnosis notes, medical history, lab test orders, and prescription writer. | `pages/consultation.html` |
| **12** | **Prescription Management** | Itemized medication table with dosages, frequency instructions, and printable Rx sheet. | `pages/prescriptions.html` |
| **13** | **Billing & Invoicing** | Itemized invoice breakdown (Consultation, Diagnostics, Pharmacy), payment status badges, and printable receipts. | `pages/billing.html` |
| **14** | **Preventive Health Checkup** | Biometric monitoring (BP, BMI, Blood Glucose, SpO2), health checkup packages, and encounter logging. | `pages/health-checkup.html` |
| **15** | **Discharge Summary** | Inpatient medical report, admission/discharge timeline, diagnostic findings, and doctor discharge orders. | `pages/discharge-summary.html` |
| **16** | **Hospital Asset Management** | Biomedical inventory tracking, maintenance schedules, room locations, and status tags. | `pages/assets.html` |
| **17** | **Patient Ratings & Reviews** | Verified patient review system, 5-star breakdown bars, doctor ratings, and submission modal. | `pages/ratings.html` |
| **18** | **Waiting Room Queue** | Real-time token queue tracker, patient arrival timestamps, triage urgency badges, and status updates. | `pages/waiting-time.html` |
| **19** | **Document Records** | Clinical repository for lab reports, radiology imaging files, discharge notes, and insurance forms. | `pages/documents.html` |

---

## Technology Stack

- **Structure**: Semantic HTML5 with accessibility attributes and descriptive IDs.
- **Styling**: Bootstrap 5.3.3, Bootstrap Icons 1.11.3, and custom CSS design system.
- **Typography**: **Plus Jakarta Sans** (clean, geometric modern UI) paired with **Outfit** (contemporary rounded headings and stat numbers).
- **Interactivity & Logic**: Vanilla JavaScript (ES6+) with modular service architecture (`HMSAuth`, `HMSApi`, `HMSDataStore`, `HMSNav`, `HMSApp`).
- **Data Persistence**: Client-side `localStorage` state management pre-seeded with realistic clinical dummy data.
- **Charts & Visualization**: Chart.js for interactive line charts, area fills, and doughnut diagrams.
- **Responsiveness**: Fully responsive across compact smartphones (320px+), tablets, laptops, and 4K displays.

---

## Project Structure

```
HMS/
├── assets/
│   ├── css/
│   │   └── style.css            # Master stylesheet with design tokens & responsive breakpoints
│   ├── js/
│   │   ├── apiService.js        # API facade ready for future PHP/MySQL backend migration
│   │   ├── app.js               # Utility helpers, toast notifications, currency formatters
│   │   ├── auth.js              # Role-based authentication & profile switcher
│   │   ├── dataStore.js         # LocalStorage persistence wrapper
│   │   └── navigation.js        # Dynamic role-aware sidebar & header renderer
│   └── images/
│       ├── avatars/             # Profile avatars
│       ├── doctors/             # Doctor portraits
│       ├── hospital-building.jpg # Crisp hero banner image
│       └── login-bg.jpg         # Stethoscope & clinic background
├── data/
│   └── dummyData.js             # Seed database (Patients, Doctors, Appointments, Bills, Assets)
├── pages/
│   ├── admin/
│   │   └── dashboard.html       # Executive Admin Dashboard
│   ├── doctor/
│   │   └── dashboard.html       # Doctor Clinical Portal
│   ├── patient/
│   │   └── dashboard.html       # Patient Health Portal
│   ├── receptionist/
│   │   └── dashboard.html       # Receptionist Front Desk
│   ├── appointments.html        # Book Appointments Wizard
│   ├── assets.html              # Hospital Equipment & Assets
│   ├── billing.html             # Patient Billing & Receipts
│   ├── consultation.html        # Doctor OPD Consultation Room
│   ├── departments.html         # Clinical Divisions & HODs
│   ├── discharge-summary.html   # Patient Discharge Summaries
│   ├── doctor-appointments.html # Doctor Queue & Schedule
│   ├── doctors.html             # Doctor Directory
│   ├── documents.html           # Lab & Diagnostic Documents
│   ├── health-checkup.html      # Preventive Health & Wellness
│   ├── patients.html            # Patient Registration & Directory
│   ├── prescriptions.html       # Prescription Management & Rx
│   ├── ratings.html             # Patient Reviews & Ratings
│   ├── settings.html            # System & Profile Settings
│   └── waiting-time.html        # OPD Waiting Queue Tracker
├── index.html                   # Public Hospital Homepage (Root Landing)
├── home.html                    # Homepage Alias / Mirror
├── login.html                   # Staff & Patient Authentication Portal
├── vercel.json                  # Vercel Deployment & Route Rewrites
├── .gitignore                   # Git ignore file
└── README.md                    # Documentation
```

---

## Getting Started

### Deploy on Vercel
1. Import this repository into **[Vercel](https://vercel.com/)**.
2. No build command is required (Framework Preset: *Other*).
3. The root URL (`/`) will immediately open the **Hospital Homepage**, with full navigation to all departments, booking wizards, and portals.

### Using XAMPP (Apache)
1. Clone or place this repository into your XAMPP `htdocs` directory:
   ```bash
   c:\xampp\htdocs\HMS
   ```
2. Start the **Apache** server from the XAMPP Control Panel.
3. Open your browser and navigate to:
   - **Homepage**: `http://localhost/HMS/index.html` (or `http://localhost/HMS/`)
   - **Login Portal**: `http://localhost/HMS/login.html`

### Using Any Local HTTP Server
You can also run it with Python or Node.js:
```bash
# Python 3
python -m http.server 8000

# Open in browser:
http://localhost:8000/
```

---

## Demo Credentials & Role Switching

You can log in directly using the role dropdown on the login page or switch roles instantly from the top-right header menu (`Simulate Role View`):

| Role | Username / Email | Password | Name |
|---|---|---|---|
| **Admin** | `admin@medpulse.com` | `admin123` | Dr. Arthur Pendelton |
| **Doctor** | `dr.jenkins@medpulse-hms.com` | `doctor123` | Dr. Sarah Jenkins |
| **Receptionist** | `reception@medpulse.com` | `recep123` | Karen Williams |
| **Patient** | `robert.harrison@example.com` | `patient123` | Robert Harrison |

---

## License
MIT License. Created for Hospital Management System (HMS).
