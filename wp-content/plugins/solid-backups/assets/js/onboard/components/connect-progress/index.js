/**
 * WordPress dependencies
 */
import { Flex, FlexBlock } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

/**
 * SolidWP dependencies
 */
import { StepIndicator, SurfaceVariant, Text, TextSize, TextWeight } from '@ithemes/ui';

/**
 * Internal dependencies
 */
import { StyledContainer, StyledProgressBar } from './styles';
import { useProgress } from '../../store/context';

export default function ConnectProgress() {
	const { state } = useProgress();
	const [ step, text ] = getActionText( state.connectAction );

	return (
		<StyledContainer>
			<StepIndicator step={ step } surfaceVariant={ SurfaceVariant.PRIMARY_CONTRAST } textSize={ TextSize.SMALL } />

			<FlexBlock>
				<Flex direction="column" expanded={ false } gap={ 4 } align="start">
					<Text text={ text } weight={ TextWeight.HEAVY } />
					<StyledProgressBar value={ state.isConnecting ? null : 0 } />
				</Flex>
			</FlexBlock>
		</StyledContainer>
	);
}

function getActionText( action ) {
	switch ( action ) {
		case '':
		case 'checkPlugin':
			return [ 1, __( 'Checking for Solid Central companion plugin.', 'it-l10n-solid-backups' ) ];
		case 'activate':
			return [ 2, __( 'Activating Solid Central companion plugin.', 'it-l10n-solid-backups' ) ];
		case 'install':
			return [ 2, __( 'Installing Solid Central companion plugin.', 'it-l10n-solid-backups' ) ];
		case 'checkConnection':
			return [ 3, __( 'Checking for an existing Solid Central connection.', 'it-l10n-solid-backups' ) ];
		case 'connect':
			return [ 4, __( 'Setting up connection with Solid Central.', 'it-l10n-solid-backups' ) ];
	}
}
