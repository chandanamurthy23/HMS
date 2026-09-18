<?php
/**
 * Hospital Management System (HMS) - Automated Email Dispatcher
 * Sends formatted HTML emails for patient welcome credentials, password resets, and notifications.
 * Works natively with PHP mail() on Hostinger, cPanel, and LAMP/LEMP stacks.
 */

require_once __DIR__ . '/config.php';

class HMSMailer {

    /**
     * Send new patient/user welcome credentials email
     */
    public static function sendWelcomeCredentials(string $toEmail, string $fullName, string $tempPassword, string $roleName = 'Patient'): array {
        $loginUrl = rtrim(SITE_URL, '/') . '/login.html';
        $siteName = defined('SITE_NAME') ? SITE_NAME : 'MedPulse Hospital';
        $sitePhone = defined('SITE_PHONE') ? SITE_PHONE : '+91 98765 43210';
        $siteAddress = defined('SITE_ADDRESS') ? SITE_ADDRESS : 'Healthcare District, Bangalore';

        $subject = "Welcome to $siteName - Your Patient Portal Login Credentials";

        $htmlBody = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <style>
    body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f1f5f9; margin: 0; padding: 20px; color: #1e293b; }
    .email-container { max-width: 580px; margin: 0 auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 16px rgba(0,0,0,0.06); }
    .email-header { background: linear-gradient(135deg, #0d6efd 0%, #0052cc 100%); color: #ffffff; padding: 28px 32px; text-align: center; }
    .email-header h1 { margin: 0 0 6px 0; font-size: 24px; font-weight: 700; letter-spacing: -0.5px; }
    .email-header p { margin: 0; opacity: 0.9; font-size: 13px; }
    .email-body { padding: 32px; }
    .greeting { font-size: 16px; font-weight: 600; margin-bottom: 12px; color: #0f172a; }
    .info-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 18px; margin: 20px 0; }
    .credential-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #edf2f7; font-size: 14px; }
    .credential-row:last-child { border-bottom: none; }
    .credential-label { color: #64748b; font-weight: 500; }
    .credential-val { color: #0f172a; font-family: monospace; font-size: 15px; font-weight: 700; }
    .btn-login { display: block; width: fit-content; margin: 24px auto; background: #0d6efd; color: #ffffff !important; text-decoration: none; padding: 12px 28px; border-radius: 8px; font-weight: 600; font-size: 15px; text-align: center; }
    .note-box { background: #eff6ff; border-left: 4px solid #3b82f6; padding: 12px; border-radius: 4px; font-size: 12.5px; color: #1e40af; margin-top: 18px; }
    .email-footer { background: #f8fafc; padding: 20px 32px; text-align: center; font-size: 12px; color: #94a3b8; border-top: 1px solid #f1f5f9; }
  </style>
</head>
<body>
  <div class="email-container">
    <div class="email-header">
      <h1>$siteName</h1>
      <p>Official Patient Electronic Health Record Portal</p>
    </div>
    <div class="email-body">
      <div class="greeting">Dear $fullName,</div>
      <p style="font-size: 14px; line-height: 1.6; color: #334155;">
        Your hospital electronic profile and <strong>$roleName Portal</strong> account have been successfully registered by Hospital Administration.
      </p>
      
      <div class="info-box">
        <div style="font-weight: 700; color: #0d6efd; margin-bottom: 10px; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Your Portal Access Credentials</div>
        <div class="credential-row">
          <span class="credential-label">Portal Access Link:</span>
          <span class="credential-val"><a href="$loginUrl" style="color:#0d6efd; text-decoration:none;">$loginUrl</a></span>
        </div>
        <div class="credential-row">
          <span class="credential-label">Login Username / Email:</span>
          <span class="credential-val">$toEmail</span>
        </div>
        <div class="credential-row">
          <span class="credential-label">Temporary Password:</span>
          <span class="credential-val" style="color: #dc2626; background: #fef2f2; padding: 2px 8px; border-radius: 4px;">$tempPassword</span>
        </div>
        <div class="credential-row">
          <span class="credential-label">Designated Role:</span>
          <span class="credential-val" style="color: #0d6efd;">$roleName</span>
        </div>
      </div>

      <a href="$loginUrl" class="btn-login" target="_blank">Sign In to Your Health Portal &rarr;</a>

      <div class="note-box">
        <strong>Security Notice:</strong> This temporary password was automatically generated. For your privacy and HIPAA compliance, you will be prompted to set a personal password upon initial sign-in. Do not share these credentials with anyone.
      </div>

      <p style="font-size: 13px; color: #64748b; margin-top: 20px; line-height: 1.5;">
        Through the portal, you can view your digital prescriptions, access diagnostic laboratory and radiology scans, review visit summaries, and manage doctor appointments 24/7.
      </p>
    </div>
    <div class="email-footer">
      <p style="margin: 0 0 6px 0;">$siteName • $siteAddress</p>
      <p style="margin: 0;">Helpline: $sitePhone • This is an automated notification, please do not reply directly to this email.</p>
    </div>
  </div>
</body>
</html>
HTML;

        return self::dispatch($toEmail, $subject, $htmlBody, [
            'type'          => 'welcome_credentials',
            'patient_name'  => $fullName,
            'temp_password' => $tempPassword,
            'role'          => $roleName
        ]);
    }

    /**
     * Send password reset notification email
     */
    public static function sendPasswordReset(string $toEmail, string $fullName, string $newPassword): array {
        $loginUrl = rtrim(SITE_URL, '/') . '/login.html';
        $siteName = defined('SITE_NAME') ? SITE_NAME : 'MedPulse Hospital';
        $subject = "Your $siteName Account Password Has Been Reset";

        $htmlBody = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <style>
    body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f1f5f9; padding: 20px; margin: 0; color: #1e293b; }
    .email-container { max-width: 580px; margin: 0 auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 16px rgba(0,0,0,0.06); }
    .email-header { background: #0f172a; color: #ffffff; padding: 24px; text-align: center; }
    .email-body { padding: 32px; }
    .password-card { background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 16px; margin: 18px 0; text-align: center; }
    .btn-login { display: block; width: fit-content; margin: 20px auto; background: #0d6efd; color: #ffffff !important; text-decoration: none; padding: 12px 28px; border-radius: 8px; font-weight: 600; font-size: 14px; }
  </style>
</head>
<body>
  <div class="email-container">
    <div class="email-header">
      <h2 style="margin:0; font-size: 20px;">$siteName Security Alert</h2>
    </div>
    <div class="email-body">
      <p>Hello <strong>$fullName</strong>,</p>
      <p>Your hospital portal login password was reset by Hospital Administration.</p>
      <div class="password-card">
        <div style="color: #991b1b; font-size: 12px; font-weight: 600; text-transform: uppercase;">Your New Temporary Password</div>
        <div style="font-size: 22px; font-family: monospace; font-weight: bold; color: #dc2626; margin-top: 6px;">$newPassword</div>
      </div>
      <a href="$loginUrl" class="btn-login" target="_blank">Sign In Now</a>
      <p style="font-size: 12px; color: #64748b;">If you did not request this password change, please contact Hospital Security immediately.</p>
    </div>
  </div>
</body>
</html>
HTML;

        return self::dispatch($toEmail, $subject, $htmlBody, [
            'type'         => 'password_reset',
            'user_name'    => $fullName,
            'new_password' => $newPassword
        ]);
    }

    /**
     * Core dispatch function using SMTP Socket or PHP mail() + Audit Logging
     */
     private static function dispatch(string $toEmail, string $subject, string $htmlBody, array $meta = []): array {
        $fromEmail = defined('SMTP_FROM_EMAIL') && !empty(SMTP_FROM_EMAIL) ? SMTP_FROM_EMAIL : (defined('MAIL_FROM_ADDRESS') ? MAIL_FROM_ADDRESS : 'no-reply@medpulse-hms.com');
        $fromName  = defined('SMTP_FROM_NAME') && !empty(SMTP_FROM_NAME) ? SMTP_FROM_NAME : 'MedPulse Hospital';

        $sent = false;
        $errorMsg = null;

        // 1. Try Direct SMTP Delivery if SMTP is configured
        if (defined('SMTP_ENABLED') && SMTP_ENABLED && defined('SMTP_HOST') && !empty(SMTP_USER) && !empty(SMTP_PASS)) {
            $smtpResult = self::sendViaSMTP($toEmail, $subject, $htmlBody, [
                'host'      => SMTP_HOST,
                'port'      => defined('SMTP_PORT') ? SMTP_PORT : 465,
                'secure'    => defined('SMTP_SECURE') ? SMTP_SECURE : 'ssl',
                'user'      => SMTP_USER,
                'pass'      => SMTP_PASS,
                'from'      => !empty(SMTP_FROM_EMAIL) ? SMTP_FROM_EMAIL : SMTP_USER,
                'from_name' => $fromName
            ]);

            if ($smtpResult['success']) {
                $sent = true;
            } else {
                $errorMsg = $smtpResult['error'] ?? 'SMTP Delivery Failed';
            }
        }

        // 2. Fallback to PHP native mail() if SMTP not configured or failed
        if (!$sent) {
            $headers  = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8\r\n";
            $headers .= "From: $fromName <$fromEmail>\r\n";
            $headers .= "Reply-To: $fromEmail\r\n";
            $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";

            try {
                $sent = @mail($toEmail, $subject, $htmlBody, $headers);
            } catch (Exception $e) {
                $sent = false;
                $errorMsg = $e->getMessage();
            }
        }

        // Always log to audit log file (uploads/mail_log.txt)
        self::logEmail($toEmail, $subject, $meta, $sent, $errorMsg);

        return [
            'success'     => true,
            'mail_sent'   => $sent,
            'recipient'   => $toEmail,
            'subject'     => $subject,
            'error'       => $errorMsg,
            'meta'        => $meta,
            'message'     => $sent 
                ? "Email delivered live to $toEmail" 
                : "Email logged to audit log for $toEmail"
        ];
    }

    /**
     * Native Pure-PHP Socket SMTP Client (No Composer/External Dependencies Required)
     */
    private static function sendViaSMTP(string $to, string $subject, string $htmlBody, array $config): array {
        $host = $config['host'];
        $port = (int)$config['port'];
        $user = $config['user'];
        $pass = $config['pass'];
        $from = (!empty($config['from']) && stripos($host, 'gmail') === false) ? $config['from'] : $user;
        $fromName = $config['from_name'];
        $isSsl = ($config['secure'] === 'ssl' || $port === 465);

        $targetHost = ($isSsl ? 'ssl://' : '') . $host;
        $timeout = 15;
        $socket = @fsockopen($targetHost, $port, $errno, $errstr, $timeout);

        if (!$socket) {
            return ['success' => false, 'error' => "Cannot connect to SMTP server $host:$port ($errstr, error code $errno)"];
        }

        stream_set_timeout($socket, $timeout);

        $read = function() use ($socket) {
            $data = '';
            while ($line = fgets($socket, 515)) {
                $data .= $line;
                $trimmed = trim($line);
                if (strlen($line) >= 4 && substr($line, 3, 1) === ' ') break;
                if (strlen($trimmed) === 3 && is_numeric($trimmed)) break;
            }
            return $data;
        };

        $write = function($cmd) use ($socket) {
            fputs($socket, $cmd . "\r\n");
        };

        $initRes = $read(); // Initial 220 banner
        if (substr($initRes, 0, 3) !== '220') {
            fclose($socket);
            return ['success' => false, 'error' => "Invalid initial SMTP response: " . trim($initRes)];
        }

        // 1. EHLO
        $write("EHLO localhost");
        $ehloRes = $read();

        // 2. STARTTLS if port 587
        if (!$isSsl && ($config['secure'] === 'tls' || $port === 587)) {
            $write("STARTTLS");
            $tlsRes = $read();
            if (substr($tlsRes, 0, 3) !== '220') {
                fclose($socket);
                return ['success' => false, 'error' => "STARTTLS not accepted by server: " . trim($tlsRes)];
            }
            if (!stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
                fclose($socket);
                return ['success' => false, 'error' => "TLS encryption handshake failed."];
            }
            $write("EHLO localhost");
            $read();
        }

        // 3. AUTH LOGIN
        $write("AUTH LOGIN");
        $authPrompt = $read();
        if (substr($authPrompt, 0, 3) !== '334') {
            fclose($socket);
            return ['success' => false, 'error' => "SMTP Server rejected AUTH LOGIN: " . trim($authPrompt)];
        }

        $write(base64_encode($user));
        $userPrompt = $read();
        if (substr($userPrompt, 0, 3) !== '334') {
            fclose($socket);
            return ['success' => false, 'error' => "SMTP rejected username: " . trim($userPrompt)];
        }

        $write(base64_encode($pass));
        $passRes = $read();
        if (substr($passRes, 0, 3) !== '235') {
            fclose($socket);
            return ['success' => false, 'error' => "SMTP Authentication failed (check your email/App Password): " . trim($passRes)];
        }

        // 4. MAIL FROM
        $write("MAIL FROM: <$from>");
        $fromRes = $read();
        if (substr($fromRes, 0, 1) !== '2') {
            fclose($socket);
            return ['success' => false, 'error' => "Sender address rejected ($from): " . trim($fromRes)];
        }

        // 5. RCPT TO
        $write("RCPT TO: <$to>");
        $toRes = $read();
        if (substr($toRes, 0, 1) !== '2') {
            fclose($socket);
            return ['success' => false, 'error' => "Recipient address rejected ($to): " . trim($toRes)];
        }

        // 6. DATA
        $write("DATA");
        $dataRes = $read();
        if (substr($dataRes, 0, 3) !== '354') {
            fclose($socket);
            return ['success' => false, 'error' => "Server rejected DATA command: " . trim($dataRes)];
        }

        // 7. Headers & Message Body
        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $headers .= "From: =?UTF-8?B?" . base64_encode($fromName) . "?= <$from>\r\n";
        $headers .= "To: <$to>\r\n";
        $headers .= "Subject: =?UTF-8?B?" . base64_encode($subject) . "?=\r\n";
        $headers .= "Date: " . date('r') . "\r\n";
        $headers .= "X-Mailer: MedPulse-HMS-PurePHP\r\n";

        $write($headers . "\r\n" . $htmlBody . "\r\n.");
        $res = $read();

        $write("QUIT");
        fclose($socket);

        $success = (substr($res, 0, 3) === '250');
        return [
            'success' => $success,
            'error'   => $success ? null : "Server rejected email body: " . trim($res)
        ];
    }

    /**
     * Audit log dispatched emails into uploads/mail_log.txt
     */
    private static function logEmail(string $toEmail, string $subject, array $meta, bool $mailSentStatus, ?string $errorMsg = null): void {
        try {
            $logDir = defined('UPLOAD_DIR') ? UPLOAD_DIR : __DIR__ . '/../uploads/';
            if (!is_dir($logDir)) {
                @mkdir($logDir, 0777, true);
            }
            $logFile = $logDir . 'mail_log.txt';
            $entry = sprintf(
                "[%s] DISPATCHED TO: %s | SUBJECT: %s | TYPE: %s | STATUS: %s%s | DETAILS: %s\n",
                date('Y-m-d H:i:s'),
                $toEmail,
                $subject,
                $meta['type'] ?? 'general',
                $mailSentStatus ? 'LIVE_DELIVERED' : 'LOGGED_LOCAL',
                $errorMsg ? " (NOTE: $errorMsg)" : '',
                json_encode($meta)
            );
            @file_put_contents($logFile, $entry, FILE_APPEND | LOCK_EX);
        } catch (Exception $e) {
            // Ignore logging errors silently
        }
    }
}
