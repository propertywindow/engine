<?php declare(strict_types=1);

namespace ConversationBundle\DataFixtures\ORM;

use ConversationBundle\Entity\EmailTemplate;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class LoadEmailTemplateData
 * @package ConversationBundle\DataFixtures\ORM
 */
class LoadEmailTemplateData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $emailTemplate = new EmailTemplate();
        $emailTemplate->setAgent($this->getReference('agent_propertywindow_1'));
        $emailTemplate->setCategory($this->getReference('email_template_category_user'));
        $emailTemplate->setName('user_invite_email');
        $emailTemplate->setActive(true);
        $emailTemplate->setSubject('Invitation to create an account');
        $emailTemplate->setBodyHTML('<!DOCTYPE html><html lang="en" xmlns="http://www.w3.org/1999/xhtml" 
xmlns:v="urn:schemas-microsoft-com:vml" 
xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="x-apple-disable-message-reformatting">
    
    <title>Invitation to create an account</title>

    <!-- Web Font / @font-face : BEGIN -->
    <!-- NOTE: If web fonts are not required, lines 10 - 27 can be safely removed. -->

    <!--[if mso]>
    <style>
        * {
            font-family: sans-serif !important;
        }
    </style>
    <![endif]-->

    <!-- Web Font / @font-face : END -->

    <!-- CSS Reset -->
    <style>
        html,
        body {
            margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
        }

        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        div[style*="margin: 16px 0"] {
            margin:0 !important;
        }

        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }
        
        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            margin: 0 auto !important;
        }
        table table table {
            table-layout: auto;
        }

        img {
            -ms-interpolation-mode:bicubic;
        }

        *[x-apple-data-detectors],	/* iOS */
        .x-gmail-data-detectors, 	/* Gmail */
        .x-gmail-data-detectors *,
        .aBn {
            border-bottom: 0 !important;
            cursor: default !important;
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        .a6S {
            display: none !important;
            opacity: 0.01 !important;
        }
 
        img.g-img + div {
            display:none !important;
        }
        
        .button-link {
            text-decoration: none !important;
        }

        @media only screen and (min-device-width: 375px) and (max-device-width: 413px) { 
            .email-container {
                min-width: 375px !important;
            }
        }
        
        .pretext {
            display: none;
            font-size: 1px;
            line-height: 1px;
            max-height: 0px;
            max-width: 0px;
            opacity: 0;
            overflow: hidden;
            mso-hide: all;
            font-family: sans-serif;
        }

        .footer-td {
            padding: 40px 10px;
            width: 100%;
            font-size: 12px;
            font-family: sans-serif;
            line-height:18px;
            text-align: center;
            color: #888888;
        }
        
        .footer-text {
            padding: 40px;
            text-align: center;
            font-family: sans-serif;
            font-size: 15px;
            line-height: 20px;
            color: #ffffff;
        }
        
        .action-button {
            background: #005480;
            border: 15px solid #005480;
            font-family: sans-serif;
            font-size: 13px;
            line-height: 1.1;
            text-align: center;
            text-decoration: none;
            display: block;
            border-radius: 3px;
            font-weight: bold;
        }
        
        .header-logo {
            height: auto;
            background: #EEEEEE;
            font-family: sans-serif;
            font-size: 15px;
            line-height: 20px;
            color: #555555;
        }
        
        .header-image {
            width: 100%;
            max-width: 600px;
            height: auto;
            background: #dddddd;
            font-family: sans-serif;
            font-size: 15px;
            line-height: 20px;
            color: #555555;
            margin: auto;
        }
        
        .button-td {
            padding: 0 40px;
            font-family: sans-serif;
            font-size: 15px;
            line-height: 20px;
            color: #555555;
        }
        
        .header-title {
            margin: 0 0 10px 0;
            font-family: sans-serif;
            font-size: 24px;
            line-height: 27px;
            color: #333333;
            font-weight: normal;
        }
        
        .title-td {
            padding: 40px;
            font-family: sans-serif;
            font-size: 15px;
            line-height: 20px;
            color: #555555;
        }
    </style>

    <!-- Progressive Enhancements -->
    <style>

        /* What it does: Hover styles for buttons */
        .button-td,
        .button-a {
            transition: all 100ms ease-in;
        }
        .button-td:hover,
        .button-a:hover {
            background: #5191CD !important;
            border-color: #5191CD !important;
        }

        /* Media Queries */
        @media screen and (max-width: 600px) {

            /* What it does: Adjust typography on small screens to improve readability */
            .email-container p {
                font-size: 17px !important;
                line-height: 22px !important;
            }

        }

    </style>

    <!-- What it does: Makes background images in 72ppi Outlook render at correct size. -->
    <!--[if gte mso 9]>
    <xml>
        <o:OfficeDocumentSettings>
            <o:AllowPNG/>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
    <![endif]-->

</head>
<body width="100%" bgcolor="#EEEEEE" style="margin: 0; mso-line-height-rule: exactly;">
<center style="width: 100%; background: #EEEEEE; text-align: left;">

    <!-- Visually Hidden Preheader Text : BEGIN -->
    <div class="pretext">
        You have been invited to create an account on property window.
    </div>
    <!-- Visually Hidden Preheader Text : END -->


    <div style="max-width: 600px; margin: auto;" class="email-container">
        <!--[if mso]>
        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="600" align="center">
            <tr>
                <td>
        <![endif]-->

        <!-- Email Header : BEGIN -->
        <table role="presentation" cellspacing="0" cellpadding="0" 
        border="0" align="center" width="100%" style="max-width: 600px;">
            <tr>
                <td style="padding: 20px 0; text-align: center">
                    <img src="http://www.propertywindow.com/assets/images/pw-logo-windows.png" 
                    width="200" 
                    height="50" 
                    border="0" 
                    class="header-logo">
                </td>
            </tr>
        </table>
        <!-- Email Header : END -->

        <!-- Email Body : BEGIN -->
        <table role="presentation" cellspacing="0" cellpadding="0" border="0" 
        align="center" width="100%" style="max-width: 600px;">

            <!-- Header Image : BEGIN -->
            <tr>
                <td bgcolor="#ffffff" align="center">
                    <img src="http://placehold.it/1200x600" width="600" height="" alt="alt_text" 
                    border="0" align="center" class="g-img header-image">
                </td>
            </tr>
            <!-- Header Image : END -->

            <!-- 1 Column Text + Button : BEGIN -->
            <tr>
                <td bgcolor="#ffffff">
                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                            <td class="title-td">
                                <h1 class="header-title">
                                Invitation to create an account.
                                </h1>
                                <p style="margin: 0;">Hi {{ name }}! You\'re successfully registered.</p>
                                <p style="margin: 0;">You can login with the password: <b>{{ password }}</b></p>
                            </td>
                        </tr>
                        <tr>
                            <td class="button-td">
                                <!-- Button : BEGIN -->
                                <table role="presentation" cellspacing="0" cellpadding="0" border="0"
                                align="center" style="margin: auto;">
                                    <tr>
                                        <td style="border-radius: 3px; background: #ffffff; text-align: center;" 
                                        class="button-td">
                                            <a href="https://www.propertywindow.com" class="button-a action-button">
                                                <span style="color:#ffffff;" class="button-link">
                                                &nbsp;&nbsp;&nbsp;&nbsp;Create Account&nbsp;&nbsp;&nbsp;&nbsp;
                                                </span>
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                                <!-- Button : END -->
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <!-- 1 Column Text + Button : END -->

            <!-- 2 Even Columns : BEGIN -->
            <tr>
                <td bgcolor="#ffffff" align="center" height="100%" 
                valign="top" width="100%" style="padding-bottom: 40px">
                    &nbsp;
                </td>
            </tr>
            <!-- Two Even Columns : END -->

            <!-- Clear Spacer : BEGIN -->
            <tr>
                <td aria-hidden="true" height="40" style="font-size: 0; line-height: 0;">
                    &nbsp;
                </td>
            </tr>
            <!-- Clear Spacer : END -->


        </table>
        <!-- Email Body : END -->

        <!-- Email Footer : BEGIN -->
        <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" 
        style="max-width: 680px;">
            <tr>
                <td style="" class="x-gmail-data-detectors footer-td">
                    &nbsp;
                </td>
            </tr>
        </table>
        <!-- Email Footer : END -->

        <!--[if mso]>
        </td>
        </tr>
        </table>
        <![endif]-->
    </div>

    <!-- Full Bleed Background Section : BEGIN -->
    <table role="presentation" bgcolor="#78A22F" cellspacing="0" cellpadding="0" border="0" align="center" width="100%">
        <tr>
            <td valign="top" align="center">
                <div style="max-width: 600px; margin: auto;" class="email-container">
                    <!--[if mso]>
                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="600" align="center">
                        <tr>
                            <td>
                    <![endif]-->
                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                            <td class="footer-text">
                                <p style="margin: 0;">
                                Property Window<br>27 Portobello High Street, EH15 1DE, Edinburgh, GB<br>0131 657 1666
                                </p>
                            </td>
                        </tr>
                    </table>
                    <!--[if mso]>
                    </td>
                    </tr>
                    </table>
                    <![endif]-->
                </div>
            </td>
        </tr>
    </table>
    <!-- Full Bleed Background Section : END -->

</center>
</body>
</html>');
        $emailTemplate->setBodyTXT('You did it! You registered!

Hi {{ name }}! You\'re successfully registered.
You can login with the password: {{ password }}

Thanks!');
        $manager->persist($emailTemplate);

        $manager->flush();
    }

    /**
     * @return integer
     */
    public function getOrder()
    {
        return 41;
    }
}
