@component('mail::message')
# Dear, {{$content['guardian']->title}} {{ $content['guardian']->last_name }}

Follow the link below to access {{ $content['student']->first_name }} {{ $content['student']->last_name }}'s performance report for {{ $content['term']->name }} {{ $content['academicSession']->name }} academic session.
Please view on a computer for the best experience.

@component('mail::button', ['url' => $content['url']])
Click Here
@endcomponent

The link expires in a week. Ensure to print the result before then.

Thanks,
Radiant Minds School.
@endcomponent