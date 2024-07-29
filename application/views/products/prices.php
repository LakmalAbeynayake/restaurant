<?php
function getProductColor($productCode) {
    // Extract the last digit from the product code
    $lastDigit = substr($productCode, -1);

    // Define a list of colors
    $colors = [
        '0' => 'rgb(255, 0, 0)',       // Red
        '1' => 'rgb(0, 255, 0)',       // Green
        '2' => 'rgb(119 119 255)',       // Blue
        '3' => 'rgb(255, 255, 0)',     // Yellow
        '4' => 'rgb(255 115 255)',     // Magenta
        '5' => 'rgb(0, 255, 255)',     // Cyan
        '6' => 'rgb(255 72 72)',       // Maroon
        '7' => 'rgb(0, 128, 0)',       // Green (128)
        '8' => 'rgb(207 207 207)',       // Navy
        '9' => 'rgb(128, 128, 0)',     // Olive
        // Add more colors as needed
    ];

    // If the last digit exists in the color map, return the corresponding color
    if (array_key_exists($lastDigit, $colors)) {
        return $colors[$lastDigit];
    } else {
        // If the last digit doesn't exist in the color map, generate a random color
        return generateRandomColor();
    }
}
function generateRandomColor() {
    // Generate random values for Red, Green, and Blue components
    $red = mt_rand(0, 255);
    $green = mt_rand(0, 255);
    $blue = mt_rand(0, 255);

    // Return the RGB color in the format "rgb(red, green, blue)"
    return "rgb($red, $green, $blue)";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Product Prices</title>
<!-- Add DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<style>
    /* Basic CSS for table */
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }
    th {
        background-color: #f2f2f2;
    }
</style>
</head>
<body>

<h2>Product Prices</h2>

<table id="product_table" style="font-family: monospace;font-weight: bold;font-size: large;">
    <thead>
        <tr>
            <th>LP ID</th>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Product Code</th>
            <th>Location ID</th>
            <th>Price Type</th>
            <th>Price</th>
            <th>Is Active</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($price_list as $price):
                if(!isset($price->product_name)) continue;
        ?>
        <tr style="background-color: <?php echo getProductColor($price->product_code); ?>">
            <td><?php echo $price->lp_id; ?></td>
            <td><?php echo $price->product_id; ?></td>
            <td><?php echo $price->product_name; ?></td>
            <td><?php echo $price->product_code; ?></td>
            <td><?php echo $price->location_id == 1 ? "SINGHA ONE":($price->location_id == 2 ? "SINGHA TWO" : "SINGHA THREE"); ?></td>
            <td><?php echo $price->price_type == 1 ? 'dine-in' : 'take-away'; ?></td>
            <td><input class="price" data-ori_value="<?php echo $price->price; ?>" data-lp_id="<?php echo $price->lp_id; ?>" id="price_<?php echo $price->lp_id; ?>" value="<?php echo $price->price; ?>"></td>
            <td><?php echo $price->is_active; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Add jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Add DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    // Initialize DataTable
    $(document).ready(function() {
        $('#product_table').DataTable();
    });
    
    $(document).on('input', '.price', function() {
        var currentValue = $(this).val();
        var lp_id = $(this).data('lp_id');
        var ori_value = $(this).data('ori_value');
        if (!isValidDecimal(currentValue)) {
            alert("Please enter a valid decimal number for the price.");
            $(this).val(ori_value); // Reset the input value
        } else {
            // Create a POST request
            
        }
    });
    $(document).on('change', '.price', function() {
        var currentValue = $(this).val();
        var lp_id = $(this).data('lp_id');
        var ori_value = $(this).data('ori_value');
        if (!isValidDecimal(currentValue)) {
            alert("Please enter a valid decimal number for the price.");
            $(this).val(ori_value); // Reset the input value
        } else {
            $.ajax({
                url: '<?php echo base_url()?>products/update_lp',
                method: 'POST',
                data: { lp_id: lp_id, currentValue: currentValue },
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    // Handle success response
                    if(response.success){
                        alert("Success");
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    // Handle error
                    alert("No changes");
                }
            });
        }
    });

    function isValidDecimal(value) {
        return /^\d+(\.\d{1,2})?$/.test(value);
    }

    function getColorFromProductCode(productCode) {
        // Assuming productCode is in the range of 0 - 990
        // You can define your own logic to determine the color based on the productCode
        var hue = (productCode / 990) * 360; // Convert productCode to a hue value between 0 and 360
        return 'hsl(' + hue + ', 100%, 80%)'; // Return a light color based on the hue
    }
</script>

</body>
</html>