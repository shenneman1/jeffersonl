import { __ } from '@wordpress/i18n';
import { Text, TextVariant } from '@ithemes/ui';
import { StyledHeader, StyledVerticalFlex, StyledWhiteLogo } from './styles';

export default function Header() {
	return (
		<StyledHeader>
			<StyledVerticalFlex>
				<Text
					text={ __( 'Welcome to SolidWP’s newest Backups solution', 'it-l10n-solid-backups' ) }
					variant={ TextVariant.WHITE }
				/>
				<StyledWhiteLogo />
			</StyledVerticalFlex>
		</StyledHeader>
	);
}
