import { __ } from '@wordpress/i18n';
import { useTheme } from '@emotion/react';
import { Heading, TextSize, TextVariant } from '@ithemes/ui';
import {
	StyledConnectionStatus, StyledStatusIndicator,
} from './styles.js';

export default function ConnectionStatus( { connectionStatus = 'unknown' } ) {
	const [ statusText, headingText, color ] = useStatus( connectionStatus );

	return (
		<StyledConnectionStatus>
			<StyledStatusIndicator
				as="div"
				color={ color }
				iconPosition="right"
				indicator={ color }
				text={ statusText }
			/>

			<Heading
				level={ 2 }
				size={ TextSize.HUGE }
				variant={ TextVariant.DARK }
				text={ headingText }
			/>
		</StyledConnectionStatus>
	);
}

function useStatus( status ) {
	const theme = useTheme();

	switch ( status ) {
		case 'connected':
			return [ __( 'Site Connected', 'it-l10n-solid-backups' ), __( 'You’re connected to Solid Backups — NextGen', 'it-l10n-solid-backups' ), '#15b22e' ];
		case 'unknown':
			return [ __( 'Checking Connection', 'it-l10n-solid-backups' ), __( 'Checking this site’s connection to Solid Backups — NextGen', 'it-l10n-solid-backups' ), theme.colors.text.muted ];
		default:
			return [ __( 'Site Disconnected', 'it-l10n-solid-backups' ), __( 'Your Site is not connected to Solid Backups — NextGen', 'it-l10n-solid-backups' ), '#B32D2E' ];
	}
}
