import { __ } from '@wordpress/i18n';
import { useViewportMatch } from '@wordpress/compose';
import {
	Heading,
	Text,
	TextVariant,
	TextSize,
	TextWeight,
} from '@ithemes/ui';
import sueSpencer from '../../../images/sue-spencer.png';
import {
	StyledTestimonial,
	StyledTestimonials,
	StyledTextContainer,
	StyledTestimonialUser,
} from './styles';

export default function Testimonials() {
	return (
		<StyledTestimonials>
			<Heading
				align="center"
				level={ 2 }
				size={ TextSize.HUGE }
				text={ __( 'Testimonial', 'it-l10n-solid-backups' ) }
			/>
			<Testimonial
				quote={ __( '“Using SolidWP products helps me make a difference in the success of others. I know I can count on them to deliver the results I want for my clients.”', 'it-l10n-solid-backups' ) }
				image={ sueSpencer }
				name={ __( 'Sue Spencer', 'it-l10n-solid-backups' ) }
				business={ __( 'Founder at Spencer Web Design', 'it-l10n-solid-backups' ) }
			/>
		</StyledTestimonials>
	);
}

function Testimonial( { quote, image, name, business } ) {
	const isLarge = useViewportMatch( 'large', '>=' );

	return (
		<StyledTestimonial>
			<StyledTextContainer>
				<Text
					size={ isLarge ? TextSize.HUGE : TextSize.EXTRA_LARGE }
					variant={ TextVariant.DARK }
					text={ quote }
				/>
				<StyledTestimonialUser>
					<Text
						size={ TextSize.HUGE }
						variant={ TextVariant.DARK }
						text={ name }
					/>
					<Text
						variant={ TextVariant.DARK } weight={ TextWeight.HEAVY } text={ business }
					/>
				</StyledTestimonialUser>
			</StyledTextContainer>
			<img src={ image } alt="" />
		</StyledTestimonial>
	);
}
