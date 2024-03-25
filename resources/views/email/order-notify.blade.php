<div style="max-width: 600px;font-family:Arial,Helvetica,sans-serif; font-size:16px; text-align:center;">
    <p>{{ $intro }}</p>
    <p style="margin:16px 0; font-size:24px;">
        <span style="font-family: monospace;">{{ $projectNumber }}</span><br>
        <strong>{{ $projectTitle }}</strong><br>
        {{ $type }}<br>
        Submitted {{ $submitted }}
    </p>
    <a style="display:block; margin:16px 48px; padding:10px; font-size:32px; background-color:#007bff; border-radius:10px; color:white; text-align:center; text-decoration:none;"
       href="{{ $url }}">View Order</a>
    <hr style="margin:24px 0;">
    <p>View this order at <a href="{{ $url }}">{{ $url }}</a></p>
    <p>
        This email notification was generated by the {{ config('custom.scl_long') }}'s {{ $appName }}.
        If you have trouble with this notification or have received this message in error, please contact the College at <strong>{{ config('custom.scl_email_treq') }}</strong>.
    </p>
</div>
