CREATE
OR REPLACE VIEW practice_item_assets AS SELECT
    item.id,
    item.title,
    item.description,
    item.file,
    item.faqs,
    item.locale,
    item.created_at,
    image.id AS image_id,
    image.imageable_type AS image_imageable_type,
    image.imageable_id AS image_imageable_id,
    image.variant AS image_variant,
    image.src AS image_src,
    image.alt AS image_alt
FROM
    practice_items item
LEFT JOIN images image
    ON image.imageable_id = item.id
    AND image.imageable_type = 'practice_item'
    AND image.variant = 'image';
