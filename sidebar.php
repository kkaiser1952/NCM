<!-- sidebar.php -->
<div id="columnSidebar" class="sidebar">
    <a href="javascript:void(0)" class="close-btn" onclick="closeSidebar()">&times;</a>
    <h3>Select Columns</h3>
    <label><input type="checkbox" value="col1" checked onchange="previewColumn('col1')"> Column 1</label><br>
    <label><input type="checkbox" value="col2" checked onchange="previewColumn('col2')"> Column 2</label><br>
    <label><input type="checkbox" value="col3" checked onchange="previewColumn('col3')"> Column 3</label><br>
    <label><input type="checkbox" value="col4" checked onchange="previewColumn('col4')"> Column 4</label><br>

    <button class="apply-btn" onclick="applyChanges()">Apply</button>
    <button class="reset-btn" onclick="resetToDefault()">Reset to Default</button>
</div>
