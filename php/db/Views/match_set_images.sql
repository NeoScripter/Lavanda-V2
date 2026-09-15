CREATE OR REPLACE VIEW match_set_images AS
    SELECT set.id, set.matcheable_id, set.advice, set.html, set.matcheable_type, set.locale, set.created_at,
    COALESCE(
        json_agg(
            json_build_object(
                'id', image.id,
                'imageable_type', image.imageable_type,
                'imageable_id', image.imageable_id,
                'variant', image.variant,
                'src', image.src,
                'alt', image.alt
            )
        ) FILTER (WHERE image.id IS NOT NULL AND (image.variant = 'front_image' OR image.variant = 'preview')), '[]'
    ) as images
    FROM match_sets set
    LEFT JOIN images image ON image.imageable_id = ANY(STRING_TO_ARRAY(set.matcheable_id, '|')::int[]) AND image.imageable_type = set.matcheable_type
    GROUP BY set.id, set.advice, set.html, set.matcheable_id, set.matcheable_type, set.locale, set.created_at;
