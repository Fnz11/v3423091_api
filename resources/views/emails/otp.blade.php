<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.5;
            background-color: #f8fafc;
            margin: 0;
            padding: 0;
        }

        .gradient-border {
            position: relative;
            background: linear-gradient(to right, #f0f9ff, #e0f2fe, #f0f9ff);
            padding: 1px;
            border-radius: 1rem;
        }

        .content {
            background: white;
            border-radius: 1rem;
            padding: 2rem;
        }
    </style>
</head>

<body>
    <div style="max-width: 600px; margin: 2rem auto; padding: 2rem;">
        <div class="gradient-border">
            <div class="content">
                <!-- Enhanced header -->
                <div style="text-align: center; margin-bottom: 2rem;">
                    <div
                        style="display: inline-block; padding: 1rem; background: linear-gradient(135deg, #6366f1, #8b5cf6); border-radius: 1rem; margin-bottom: 1.5rem;">
                        <svg style="width: 2.5rem; height: 2.5rem; color: white;" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h1 style="color: #1e293b; font-size: 1.875rem; font-weight: 700; margin-bottom: 1rem;">Verify Your
                        Email</h1>
                    <p style="color: #64748b; font-size: 1rem;">Use the verification code below to complete your
                        verification process</p>
                </div>

                <!-- Enhanced OTP display -->
                <div
                    style="background: linear-gradient(135deg, #f8fafc, #f1f5f9); padding: 2rem; border-radius: 1rem; text-align: center; margin: 2rem 0;">
                    <div
                        style="font-size: 2.5rem; letter-spacing: 0.75rem; font-weight: 700; color: #0f172a; font-family: monospace;">
                        {{ $otp }}
                    </div>
                </div>

                <!-- Enhanced footer -->
                <div style="text-align: center; margin-top: 2rem;">
                    <p style="color: #94a3b8; font-size: 0.875rem;">This code will expire in 10 minutes</p>
                    <p style="color: #94a3b8; font-size: 0.75rem; margin-top: 1.5rem;">If you didn't request this code,
                        please ignore this email.</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
