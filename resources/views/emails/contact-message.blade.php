<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Message</title>
    <style>
        /* Base Styles */
        body {
            font-family: 'Segoe UI', Roboto, -apple-system, BlinkMacSystemFont, sans-serif;
            color: #333333;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            line-height: 1.6;
        }
        
        /* Email Container */
        .email-container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }
        
        /* Header */
        .header {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            color: #ffffff;
            padding: 30px 20px;
            text-align: center;
        }
        
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        
        /* Content Area */
        .content {
            padding: 30px;
        }
        
        h2 {
            color: #2c3e50;
            font-size: 20px;
            margin-top: 0;
            margin-bottom: 25px;
            font-weight: 600;
            border-bottom: 2px solid #f1f1f1;
            padding-bottom: 10px;
        }
        
        /* Message Details */
        .details {
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
        }
        
        .detail-row {
            margin-bottom: 15px;
            display: flex;
            align-items: flex-start;
        }
        
        .detail-row:last-child {
            margin-bottom: 0;
        }
        
        .detail-label {
            font-weight: 600;
            color: #555;
            min-width: 80px;
            display: inline-block;
        }
        
        .detail-value {
            flex: 1;
            color: #333;
        }
        
        .message-content {
            background-color: white;
            border-left: 3px solid #667eea;
            padding: 15px;
            margin-top: 10px;
            border-radius: 0 5px 5px 0;
            text-align: justify;
        }
        
        /* Footer */
        .footer {
            text-align: center;
            font-size: 13px;
            color: #888;
            padding: 20px;
            background-color: #f5f5f5;
            border-top: 1px solid #eaeaea;
        }
        
        .footer p {
            margin: 5px 0;
        }
        
        /* Responsive Adjustments */
        @media only screen and (max-width: 600px) {
            .email-container {
                margin: 10px;
                border-radius: 0;
            }
            
            .content {
                padding: 20px;
            }
            
            .detail-row {
                flex-direction: column;
            }
            
            .detail-label {
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header" style="display: flex; align-items: center; justify-content: center;">
            <img src="{{ asset('images/logo2.png') }}" alt="Logo" style="height: 40px; margin-right: 15px;">
            <h1 style="margin: 0;">New Message Notification</h1>
        </div>
        
        <div class="content">
            <h2>You've received a new contact message</h2>
            
            <div class="details">
                <div class="detail-row">
                    <span class="detail-label">From:</span>
                    <span class="detail-value">{{ $details['name'] ?? 'Not provided' }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Email:</span>
                    <span class="detail-value">
                        <a href="mailto:{{ $details['email'] ?? '' }}" style="color: #667eea; text-decoration: none;">
                            {{ $details['email'] ?? 'Not provided' }}
                        </a>
                    </span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Subject:</span>
                    <span class="detail-value">{{ $details['subject'] ?? 'Not provided' }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Message:</span>
                    <div class="detail-value">
                        <div class="message-content">
                            {{ $details['message'] ?? 'Not provided' }}
                        </div>
                    </div>
                </div>
            </div>
            
            <p style="text-align: center; margin-top: 25px;">
                <a href="mailto:{{ $details['email'] }}" 
                   style="display: inline-block; background-color: #1e40af; color: white; 
                          padding: 10px 20px; border-radius: 5px; text-decoration: none;
                          font-weight: 500;">
                    Reply to {{ $details['name'] ?? 'the sender' }}
                </a>
            </p>
        </div>
        
        <div class="footer">
            <p>This message was sent via the contact form on {{ config('app.name') }}</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>