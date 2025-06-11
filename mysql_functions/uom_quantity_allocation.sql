DELIMITER $$

CREATE FUNCTION `uomQuantityAllocation`(
    `quantity` INT,
    `product_id` INT,
    `uom` VARCHAR(10)
)
RETURNS JSON
DETERMINISTIC
BEGIN
    DECLARE cs_uom_column VARCHAR(20);
    DECLARE cs_conversion DECIMAL(10, 4);
    DECLARE cs_operator CHAR(1);
    DECLARE cs_quantity DECIMAL(10, 4);
    DECLARE decimal_quantity DECIMAL(10, 4);
    DECLARE remaining_qty DECIMAL(10, 4);
    DECLARE result JSON;

    -- Initialize the result as a JSON object
    SET result = JSON_OBJECT();

    -- Find the UOM for 'CS' from the products table
    SELECT
        CASE
            WHEN stock_uom = 'CS' THEN 'stock_uom'
            WHEN order_uom = 'CS' THEN 'order_uom'
            WHEN other_uom = 'CS' THEN 'other_uom'
            ELSE NULL
        END INTO cs_uom_column
    FROM products WHERE id = product_id;

    -- If the input UOM is not 'CS' and a 'CS' UOM exists for the product
    IF uom <> 'CS' AND cs_uom_column IS NOT NULL THEN
        -- Get the conversion factor and operator for the 'CS' UOM
        SELECT
            CASE cs_uom_column
                WHEN 'stock_uom' THEN stock_uom_conversion
                WHEN 'order_uom' THEN order_uom_conversion
                WHEN 'other_uom' THEN other_uom_conversion
            END,
            CASE cs_uom_column
                WHEN 'stock_uom' THEN stock_uom_operator
                WHEN 'order_uom' THEN order_uom_operator
                WHEN 'other_uom' THEN other_uom_operator
            END
        INTO cs_conversion, cs_operator
        FROM products WHERE id = product_id;

        -- Perform the reverse conversion to get the quantity in 'CS'
        SET cs_quantity = quantityConversion(quantity, cs_conversion, cs_operator, TRUE);

        -- Get the decimal part of the 'CS' quantity
        SET decimal_quantity = cs_quantity - FLOOR(cs_quantity);

        -- If there is a decimal part, convert it back to the original UOM
        IF decimal_quantity > 0 THEN
            SET remaining_qty = quantityConversion(decimal_quantity, cs_conversion, cs_operator, FALSE);
            SET result = JSON_SET(result, CONCAT('$.', uom), FLOOR(remaining_qty));
        END IF;

        -- Add the whole number part of the 'CS' quantity to the result
        SET result = JSON_SET(result, '$.CS', FLOOR(cs_quantity));
    ELSE
        -- If the UOM is 'CS' or no 'CS' UOM is defined, return the original quantity
        SET result = JSON_SET(result, CONCAT('$.', uom), quantity);
    END IF;

    RETURN result;
END$$

DELIMITER ;