<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dropdown Positioning Test</title>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* CSS for the dropdown-trigger class */
        .dropdown-trigger {
            color: white;
            cursor: pointer;
        }

        /* CSS for the dropdown-list class */
        .dropdown-trigger {
            color: white;
            cursor: pointer;
        }
        .dropdown-list {
            position: absolute;
            display: none;
            background-color: white;
            border: 1px solid #ccc;
            padding: 5px;
        }
    </style>
</head>
<body>
    <!-- Sample HTML structure for testing -->
    <div class="dropdown-on-NetID">
        <a href="javascript:void(0);" class="dropdown-trigger" style="color: white;">Click Me</a>
        <select class="dropdown-list">
            <option value="https://example.com">Option 1</option>
            <option value="https://example.net">Option 2</option>
        </select>
    </div>

    <!-- JavaScript for dropdown behavior -->
    <script>
        $(document).ready(function() {
            $('.dropdown-on-NetID').each(function() {
                var container = $(this);
                var link = container.find('.dropdown-trigger');
                var select = container.find('.dropdown-list');

                link.on('click', function(e) {
                    e.preventDefault();
                    select.css('display', 'block');
                    select.css('position', 'absolute');
                    select.css('top', link.position().top + link.outerHeight() + 'px');
                });

                select.on('change', function() {
                    var selectedOption = select.find('option:selected');
                    var url = selectedOption.val();

                    if (url) {
                        window.open(url, '_blank');
                    }
                });
            });
        });
    </script>
</body>
</html>
