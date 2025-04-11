/**
 * External dependencies
 */
import { Markup } from 'interweave';

/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';

/**
 * SolidWP dependencies
 */
import { SurfaceVariant, Button, List, ListItem } from '@ithemes/ui';

/**
 * Internal dependencies
 */
import { PageContainer, ErrorCard } from '../components';
import { getAdminUrl } from '../utils';

export default function Error( { error } ) {
	const [ primaryLink, primaryText ] = getPrimaryAction( error );
	return (
		<PageContainer variant={ SurfaceVariant.PRIMARY } justify="center">
			<ErrorCard
				heading={ error.message }
				actions={ (
					<>
						<Button variant="secondary" href="https://go.solidwp.com/backups-ng-plugin-connect-docs" text={ __( 'Read Documentation', 'it-l10n-solid-backups' ) } />
						<Button variant="primary" href={ primaryLink } text={ primaryText } />
					</>
				) }
			>
				{ error.additional_errors && (
					<List>
						{ error.additional_errors.map( ( additional, i ) => (
							<ListItem key={ i }>
								<Markup content={ additional.message } noWrap />
							</ListItem>
						) ) }
					</List>
				) }
			</ErrorCard>
		</PageContainer>
	);
}

function getPrimaryAction( error ) {
	switch ( error.code ) {
		case 'solid.backups.activate-failed':
			return [
				getAdminUrl( 'plugins.php' ),
				__( 'Activate Plugin', 'it-l10n-solid-backups' ),
			];
		case 'solid.backups.install-failed':
			return [
				getAdminUrl( 'plugin-install.php', { s: 'Solid Central', tab: 'search', type: 'term' } ),
				__( 'Install Solid Central', 'it-l10n-solid-backups' ),
			];
		case 'solid.backups.outdated-plugin':
			return [
				getAdminUrl( 'update-core.php' ),
				__( 'Update Solid Central', 'it-l10n-solid-backups' ),
			];
		default:
			return [
				'https://go.solidwp.com/backups-ng-plugin-connect-help/',
				__( 'Get Help', 'it-l10n-solid-backups' ),
			];
	}
}
