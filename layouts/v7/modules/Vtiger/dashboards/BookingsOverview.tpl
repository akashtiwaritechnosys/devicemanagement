<div class="dashboardWidgetContent" style="text-align: center; padding: 15px;">
  <div style="font-size: 18px; color: #555;">Bookings</div>
  <div style="font-size: 32px; font-weight: bold;">{$BOOKINGS_COUNT}</div>
  <div style="color: {if $GROWTH_POSITIVE}green{else}red{/if}; font-size: 14px;">
    {if $GROWTH_POSITIVE}▲{else}▼{/if} {$BOOKINGS_GROWTH}% than last week
  </div>
</div>
