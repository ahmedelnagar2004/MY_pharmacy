<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تأكيد حجز موعدك</title>
</head>
<body>
    <h2>مرحباً {{ $appointment->patient_name }}،</h2>
    <p>تم حجز موعدك بنجاح مع الدكتور: {{ $appointment->doctor->name }}</p>
    <p>تاريخ الموعد: {{ $appointment->appointment_date }}</p>
    <p>الوقت: {{ $appointment->appointment_time }}</p>
    <p>إذا كان لديك أي استفسار، لا تتردد في التواصل معنا.</p>
    <p>مع تحيات فريق صيدليتي</p>
</body>
</html>
