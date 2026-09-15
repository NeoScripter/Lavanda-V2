CREATE
OR REPLACE VIEW stone_assets AS SELECT
    stone.id,
    stone.name,
    stone.html,
    stone.locale,
    stone.created_at,
    preview.id AS preview_id,
    preview.imageable_type AS preview_imageable_type,
    preview.imageable_id AS preview_imageable_id,
    preview.variant AS preview_variant,
    preview.src AS preview_src,
    preview.alt AS preview_alt,
    image.id AS image_id,
    image.imageable_type AS image_imageable_type,
    image.imageable_id AS image_imageable_id,
    image.variant AS image_variant,
    image.src AS image_src,
    image.alt AS image_alt
FROM
    stones stone
LEFT JOIN images preview
    ON preview.imageable_id = stone.id
    AND preview.imageable_type = 'stone'
    AND preview.variant = 'preview'
LEFT JOIN images image
    ON image.imageable_id = stone.id
    AND image.imageable_type = 'stone'
    AND image.variant = 'image';
