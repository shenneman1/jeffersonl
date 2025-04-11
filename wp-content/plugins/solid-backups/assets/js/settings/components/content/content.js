import { createInterpolateElement, useEffect, useState } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import { Button, Text, TextSize, TextVariant } from '@ithemes/ui';
import ConnectionStatus from './connection-status.js';
import LinkRowBox from './link-row-box.js';
import { StyledContent, StyledContentText, StyledLinkRow } from './styles';

const { links: centralLinks, site_id: siteId, status: initialStatus, is_authed_user: isAuthedUser } = window.backupsExports;

export default function Content() {
	const [ connectionStatus, setConnectionStatus ] = useState( initialStatus );

	useEffect( () => {
		const handleSend = ( event, data ) => {
			data.central_ping = {
				site_id: siteId,
			};
		};

		const handleTick = ( event, data ) => {
			if ( ! data.central_ping ) {
				return;
			}

			const status = data.central_ping?.backups?.connection_status || 'unknown';
			setConnectionStatus( status );
		};

		jQuery( document ).on( 'heartbeat-send', handleSend );
		jQuery( document ).on( 'heartbeat-tick', handleTick );

		return () => {
			jQuery( document ).off( 'heartbeat-send', handleSend );
			jQuery( document ).off( 'heartbeat-tick', handleTick );
		};
	}, [ setConnectionStatus ] );

	return (
		<StyledContent>
			<ConnectionStatus connectionStatus={ connectionStatus } />
			<Text
				size={ TextSize.SUBTITLE_SMALL }
				variant={ TextVariant.MUTED }
				text={ __( 'Rest easy knowing this site is being backed up to cloud storage from SolidWP. Since backups are powered by SolidWP servers, you can view, manage, download, and restore backups from Solid Central.', 'it-l10n-solid-backups' ) }
			/>
			{ isAuthedUser &&
				<StyledLinkRow >
					<LinkRowBox
						title={ __( 'View Backups in your site Timeline ', 'it-l10n-solid-backups' ) }
						text={ __( 'View backups, create/download archive files, and restore your site with one click! Find all this and more on this site’s Activity Timeline in Solid Central.', 'it-l10n-solid-backups' ) }
						url={ centralLinks.timeline }
					/>
					<LinkRowBox
						title={ __( 'Edit connection details ', 'it-l10n-solid-backups' ) }
						text={ __( 'Need to change your site details or fix your site’s connection? Edit your server credentials and site connection details by clicking here.', 'it-l10n-solid-backups' ) }
						url={ centralLinks.edit_connection }
						isDisconnected={ isDisconnected( connectionStatus ) }
					/>
				</StyledLinkRow>
			}
			<StyledContentText
				text={
					createInterpolateElement(
						__( '<a>Learn more about Solid Central</a>', 'it-l10n-solid-backups' ),
						{ a: <Button variant="link" /> }
					)
				} />
		</StyledContent>
	);
}

function isDisconnected( connectionStatus ) {
	return ( connectionStatus === 'failed' ) || ( connectionStatus === 'disconnected' );
}
