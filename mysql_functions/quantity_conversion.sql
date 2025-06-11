DELIMITER $$

CREATE FUNCTION `quantityConversion`(
    `quantity` DECIMAL(10, 4),
    `conversion` DECIMAL(10, 4),
    `operator` CHAR(1),
    `reverse` BOOLEAN
)
RETURNS DECIMAL(10, 4)
DETERMINISTIC
BEGIN
    IF operator = 'M' THEN
        IF reverse THEN
            RETURN quantity / conversion;
        ELSE
            RETURN quantity * conversion;
        END IF;
    ELSEIF operator = 'D' THEN
        IF reverse THEN
            RETURN quantity * conversion;
        ELSE
            RETURN quantity / conversion;
        END IF;
    END IF;

    RETURN quantity;
END$$

DELIMITER ;