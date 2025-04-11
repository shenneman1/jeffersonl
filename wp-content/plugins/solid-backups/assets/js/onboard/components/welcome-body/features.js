import { __ } from '@wordpress/i18n';
import { createInterpolateElement } from '@wordpress/element';
import {
	Button,
	Heading,
	Text,
	TextVariant,
	TextWeight,
} from '@ithemes/ui';
import {
	Calendar as Timeline,
	Central,
	Cloud,
	Pointer as Restore,
	Speed,
} from '../../../images';
import {
	StyledFeaturesSection,
	StyledFeatures,
	StyledFeature,
	StyledFeatureText,
	StyledPurchaseButton,
} from './styles';

export default function Features( { beginOnboarding } ) {
	return (
		<StyledFeaturesSection>
			<Heading level={ 2 } text={ __( 'With multiple WP Backup services, why Backups – NextGen?', 'it-l10n-solid-backups' ) } />
			<StyledFeatures>
				{ features.map( ( feature ) => (
					<Feature key={ feature.title } icon={ feature.icon } title={ feature.title } description={ feature.description } />
				) ) }
			</StyledFeatures>

			<StyledPurchaseButton
				href="https://go.solidwp.com/get-backups-nextgen"
				target="_blank"
				variant="primary"
				text={ __( 'Get Solid Backups - NextGen', 'it-l10n-solid-backups' ) }
			/>

			<Text
				align="center"
				variant={ TextVariant.DARK }
				weight={ TextWeight.HEAVY }
				text={
					createInterpolateElement(
						__( 'Already purchased a plan? <a>Continue here</a>', 'it-l10n-solid-backups' ),
						{ a: <Button variant="link" onClick={ beginOnboarding } /> }
					)
				} />
		</StyledFeaturesSection>
	);
}

function Feature( { icon, title, description } ) {
	return (
		<StyledFeature>
			{ icon }
			<StyledFeatureText>
				<Text
					variant={ TextVariant.DARK }
					weight={ TextWeight.HEAVY }
					text={ title }
				/>
				<Text variant={ TextVariant.MUTED } text={ description } />
			</StyledFeatureText>
		</StyledFeature>
	);
}

const features = [
	{
		title: __( 'Cloud-first Approach', 'it-l10n-solid-backups' ),
		description: __( 'Backups are initiated from cloud servers.', 'it-l10n-solid-backups' ),
		icon: <Cloud />,
	},
	{
		title: __( 'Focus on Speed and Reliability', 'it-l10n-solid-backups' ),
		description: __( 'Server-based rather than a PHP-based backup.', 'it-l10n-solid-backups' ),
		icon: <Speed style={ { height: '40px', width: '40px' } } />,
	},
	{
		title: __( 'Solid Central Integration', 'it-l10n-solid-backups' ),
		description: __( 'UI is primarily located in Solid Central.', 'it-l10n-solid-backups' ),
		icon: <Central />,
	},
	{
		title: __( '1-Click Restore', 'it-l10n-solid-backups' ),
		description: __( 'Best-in-class usability.', 'it-l10n-solid-backups' ),
		icon: <Restore />,
	},
	{
		title: __( 'Activity Log', 'it-l10n-solid-backups' ),
		description: __( 'Includes a basic timeline activity log.', 'it-l10n-solid-backups' ),
		icon: <Timeline />,
	},
];
