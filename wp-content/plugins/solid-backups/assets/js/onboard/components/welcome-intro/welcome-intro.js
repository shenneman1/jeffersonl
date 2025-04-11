import { __ } from '@wordpress/i18n';
import { check } from '@wordpress/icons';
import { useViewportMatch } from '@wordpress/compose';
import { createInterpolateElement } from '@wordpress/element';

import {
	Button,
	Heading,
	List,
	ListItem,
	SurfaceVariant,
	Text,
	TextSize,
	TextVariant,
	TextWeight,
} from '@ithemes/ui';

import {
	StyledIntro,
	StyledContinueText,
	StyledOuterTextContainer,
	StyledInnerTextContainer,
	StyledBackupsIcon,
	StyledPricingSurface,
	StyledWhiteLogo,
	StyledPrice,
} from './styles';

export default function WelcomeIntro( { beginOnboarding } ) {
	const isSmall = useViewportMatch( 'small', '<' );
	const isLarge = useViewportMatch( 'large', '>=' );

	return (
		<>
			{ ! isSmall && (
				<StyledContinueText
					variant={ TextVariant.DARK }
					weight={ TextWeight.HEAVY }
					text={
						createInterpolateElement(
							__( 'Already purchased a plan? <a>Continue here</a>', 'it-l10n-solid-backups' ),
							{ a: <Button variant="link" onClick={ beginOnboarding } /> }
						)
					} />
			) }
			<StyledIntro>
				<StyledOuterTextContainer>
					<StyledInnerTextContainer>
						<StyledBackupsIcon />
						<Heading
							level={ 2 }
							size={ isLarge ? TextSize.GIGANTIC : TextSize.HUGE }
							variant={ TextVariant.DARK }
							text={ __(
								'Welcome! The premier Backups tool for all things WordPress.',
								'it-l10n-solid-backups'
							) }
						/>
						<Text
							size={ TextSize.SUBTITLE_SMALL }
							variant={ TextVariant.MUTED }
							weight={ TextWeight.HEAVY }
							text={ __(
								'Solid Backups - NextGen integrates seamlessly with the SolidWP ecosystem and makes backups a simple and convenient occurrence. Solid Backups - NextGen is:',
								'it-l10n-solid-backups'
							) }
						/>
					</StyledInnerTextContainer>
					<List>
						<ListItem
							icon={ check }
							textVariant={ TextVariant.MUTED }
							text={ __( 'Performant', 'it-l10n-solid-backups' ) }
						/>
						<ListItem
							icon={ check }
							textVariant={ TextVariant.MUTED }
							text={ __( 'Easy-to-use', 'it-l10n-solid-backups' ) }
						/>
						<ListItem
							icon={ check }
							textVariant={ TextVariant.MUTED }
							text={ __( 'Smart', 'it-l10n-solid-backups' ) }
						/>
						<ListItem
							icon={ check }
							textVariant={ TextVariant.MUTED }
							text={ __( 'Reliable', 'it-l10n-solid-backups' ) }
						/>
					</List>

					<Button
						href="https://go.solidwp.com/get-backups-nextgen"
						target="_blank"
						variant="primary"
						text={ __( 'Get Solid Backups - NextGen', 'it-l10n-solid-backups' ) }
					/>

					<Text
						variant={ TextVariant.DARK }
						weight={ TextWeight.HEAVY }
						text={
							createInterpolateElement(
								__( 'Already purchased a plan? <a>Continue here</a>', 'it-l10n-solid-backups' ),
								{ a: <Button variant="link" onClick={ beginOnboarding } /> }
							)
						} />
				</StyledOuterTextContainer>

				<StyledPricingSurface variant={ SurfaceVariant.DARK }>
					<StyledWhiteLogo />
					<StyledPrice
						size={ TextSize.GIGANTIC }
						variant={ TextVariant.WHITE }
						text={ createInterpolateElement(
							__( '$8.25 <span>/ month</span>', 'it-l10n-solid-backups' ),
							{
								span: (
									<Text
										size={ TextSize.LARGE }
										variant={ TextVariant.WHITE }
									/>
								),
							}
						) }
					/>
				</StyledPricingSurface>
			</StyledIntro>
		</>
	);
}
