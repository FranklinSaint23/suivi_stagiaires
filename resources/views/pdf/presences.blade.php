<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 8px; margin: 10px; }
    h2 { text-align: center; color: #4b0082; font-size: 13px; margin-bottom: 10px; }
    table { width: 100%; border-collapse: collapse; }
    th { background: #4b0082; color: #fff; padding: 4px 3px; text-align: center; border: 1px solid #ddd; }
    th.name { text-align: left; }
    td { padding: 3px; text-align: center; border: 1px solid #ddd; }
    td.name { text-align: left; font-weight: bold; white-space: nowrap; }
    .present { color: #16a34a; font-weight: bold; }
    .absent { color: #dc2626; }
    tr:nth-child(even) { background: #f9f5ff; }
</style>
</head>
<body>
<h2>Récapitulatif des présences — {{ $moisNom }}</h2>

<table>
    <thead>
        <tr>
            <th class="name">Stagiaire</th>
            @for($j = 1; $j <= $nbJours; $j++)
                <th>{{ $j }}</th>
            @endfor
            <th>Total P</th>
        </tr>
    </thead>
    <tbody>
        @foreach($stagiaires as $s)
        <tr>
            <td class="name">{{ $s->nom }} {{ $s->prenom }}</td>
            @php $totalP = 0; @endphp
            @for($j = 1; $j <= $nbJours; $j++)
                @php $dayKey = str_pad($j, 2, '0', STR_PAD_LEFT); $p = $presencesMap[$s->id][$dayKey] ?? null; @endphp
                <td>
                    @if($p)
                        @if($p->present)<span class="present">P</span>@php $totalP++; @endphp
                        @else<span class="absent">A</span>@endif
                    @else<span style="color:#ccc">-</span>@endif
                </td>
            @endfor
            <td><strong>{{ $totalP }}</strong></td>
        </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>
