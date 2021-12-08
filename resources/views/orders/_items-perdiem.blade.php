<?php
    $pdv = new App\Views\PerdiemView($order);
?>
<tr>
    <td>Lodging ({!! $pdv->lodgingDetail !!})</td>
    <td>&nbsp;</td>
    <td class="text-right">${{ $pdv->lodging }}</td>
</tr>
<tr>
    <td>Meals ({!! $pdv->mealsDetail !!})</td>
    <td>&nbsp;</td>
    <td class="text-right">${{ $pdv->meals }}</td>
</tr>
