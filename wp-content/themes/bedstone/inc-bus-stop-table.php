<?php
/**
 * Uses ACF from Bus Stop pages
 */

if ( have_rows('bus_rows') ) : ?>

<table class="bus-stops-table">
    <thead>
        <tr class="table__mobile-head">
            <th>Bus Stops</th>
        </tr>
        <tr class="table__large-head">
            <th scope="col">Location</th>
            <th scope="col">Services</th>
            <th scope="col">Hours</th>
            <th scope="col">Notes</th>
        </tr>
    </thead>

    <tbody>
        <?php while ( have_rows('bus_rows') ) : the_row(); ?>
            <tr>
                <th scope="row">
                    <?php
                    if ( get_sub_field('location_title') ) {
                        echo '<h3 class="table-location__title">' . get_sub_field('location_title') . '</h3>';
                    }
                    if ( get_sub_field('map_link') ) {
                        echo '<a class="table__map-link" href="' . get_sub_field('map_link') . '" rel="external">Get Directions
                        <div class="button-circle-red">
                            <svg aria-hidden="true" role="img" focusable="false" viewBox="0 0 24 24" style="height: 24px; width:24px; margin-left:4px; margin-top:3px; position:absolute;" class="q-icon notranslate"><path d="M0 0h24v24H0z" style="fill: none;"></path><path style="fill:white;" d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"></path></svg>
                        </div></a>';
                    }
                    ?>
                    <div class="table-acf-textarea">
                        <?php the_sub_field('location_address'); ?>
                    </div>
                </th>

                <td>
                    <div class="table-acf-textarea">
                        <b class="table__mobile-heading">Services</b>
                        <?php the_sub_field('services'); ?>
                    </div>
                </td>

                <td>
                    <div class="table-acf-textarea">
                        <b class="table__mobile-heading">Hours</b>
                        <?php the_sub_field('hours'); ?>
                    </div>
                </td>

                <td>
                    <div class="table-acf-textarea">
                        <b class="table__mobile-heading">Notes</b>
                        <?php the_sub_field('notes'); ?>
                    </div>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<div class="content">
    <p class="footnote">* Locations with hours of "Meets bus" are unstaffed during the day, but a representative will be present when a bus is scheduled to arrive.</p>
</div>

<?php endif; ?>

<?php if (get_field('secondary_editor')) : ?>
    <div class="content bus-stop__secondary-editor">
        <?php the_field('secondary_editor') ?>
    </div>
<?php endif; ?> 
