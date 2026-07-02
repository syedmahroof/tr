<x-mail::message>
# Daily System Activity Summary

Here is the activity summary for **{{ $summaryData['date'] }}**.

<x-mail::table>
| Metric | Total Count |
| :--- | :---: |
| **New Visitors** | {{ $summaryData['visitors_count'] }} |
| **New Vehicles** | {{ $summaryData['vehicles_count'] }} |
| **New Deliveries** | {{ $summaryData['deliveries_count'] }} |
| **Appointments** | {{ $summaryData['appointments_count'] }} |
</x-mail::table>

<x-mail::button :url="config('app.url') . '/admin/dashboard'">
View Dashboard
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
