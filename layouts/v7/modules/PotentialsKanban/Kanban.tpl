<div class="kanban-board" style="display: flex; gap: 15px; overflow-x: auto;">
  {foreach from=$STAGES item=stage}
    <div class="kanban-column" data-stage="{$stage}" style="flex: 1; background: #f8f9fa; padding: 10px; border-radius: 8px;">
      <div class="kanban-column-header" style="font-weight: bold; margin-bottom: 10px;">{$stage}</div>
      <div class="kanban-column-body" data-stage="{$stage}" style="min-height: 300px;" ondrop="drop(event)" ondragover="allowDrop(event)">
        {foreach from=$RECORDS[$stage] item=record}
          <div class="kanban-card" data-id="{$record.crmid}" draggable="true" ondragstart="drag(event)" style="background: #fff; border: 1px solid #ccc; border-radius: 5px; margin-bottom: 10px; padding: 10px;">
            <strong>{$record.potentialname}</strong><br>
            Amount: {$record.amount}<br>
            Closing: {$record.closingdate}<br>
            Owner: {getOwnerName($record.smownerid)}
          </div>
        {/foreach}
      </div>
    </div>
  {/foreach}
</div>

<script src="modules/PotentialsKanban/resources/Kanban.js"></script>