CREATE
OR REPLACE VIEW rune_assets AS SELECT
    r.id,
    r.name,
    r.advice,
    r.locale,
    r.created_at,
    front.id AS front_id,
    front.imageable_type AS front_imageable_type,
    front.imageable_id AS front_imageable_id,
    front.variant AS front_variant,
    front.src AS front_src,
    front.alt AS front_alt,
    back.id AS back_id,
    back.imageable_type AS back_imageable_type,
    back.imageable_id AS back_imageable_id,
    back.variant AS back_variant,
    back.src AS back_src,
    back.alt AS back_alt
FROM
    runes r
LEFT JOIN images front
    ON front.imageable_id = r.id
    AND front.imageable_type = 'rune'
    AND front.variant = 'front_image'
LEFT JOIN images back
    ON back.imageable_id = r.id
    AND back.imageable_type = 'rune'
    AND back.variant = 'back_image';
