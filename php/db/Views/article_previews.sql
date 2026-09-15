CREATE
OR REPLACE VIEW article_previews AS SELECT
    a.id,
    a.description,
    a.locale,
    a.created_at,
    image.id AS preview_id,
    image.imageable_type AS preview_imageable_type,
    image.imageable_id AS preview_imageable_id,
    image.variant AS preview_variant,
    image.src AS preview_src,
    image.alt AS preview_alt
FROM
    articles a
LEFT JOIN images image
    ON image.imageable_id = a.id
    AND image.imageable_type = 'article'
    AND image.variant = 'preview';
