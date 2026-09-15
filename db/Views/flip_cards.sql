CREATE
OR REPLACE VIEW flip_cards AS SELECT
    c.id,
    c.name,
    c.description,
    c.advice,
    c.variant,
    c.locale,
    c.created_at,
    front.id AS front_id,
    front.imageable_type AS front_imageable_type,
    front.imageable_id AS front_imageable_id,
    front.variant AS front_variant,
    front.src AS front_src,
    front.alt AS front_alt,
    back.id AS back_id,
    back.imageable_type AS back_imageable_type,
    back.variant AS back_variant,
    back.src AS back_src,
    back.alt AS back_alt
FROM
    cards c
LEFT JOIN images front
    ON front.imageable_id = c.id
    AND front.imageable_type = c.variant
    AND front.variant = 'front_image'
LEFT JOIN images back
    ON back.imageable_type = c.variant
    AND back.variant = 'back_image';
