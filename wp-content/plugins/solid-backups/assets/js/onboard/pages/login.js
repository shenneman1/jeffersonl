/**
 * External dependencies
 */
import styled from '@emotion/styled';

/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { Flex } from '@wordpress/components';
import { arrowRight } from '@wordpress/icons';

/**
 * SolidWP dependencies
 */
import { Heading, Text, SurfaceVariant, TextSize, TextWeight, Button, TextVariant, MessageList } from '@ithemes/ui';
import { PageContainer, Gears } from '../components';
import storage from '../../images/storage.svg';

const StyledPageContainer = styled( PageContainer )`
	background-image: url(${ storage });
	background-repeat: no-repeat;
	background-position: bottom left;
`;

const StyledContent = styled( Flex )`
	z-index: 1;
	max-width: 76ch;
	align-self: center;
`;

const StyledContinue = styled( Button )`
	width: 100%;
	justify-content: center !important;
`;

export default function Connect( { connectLink, isExisting, isExpired } ) {
	const bodyText = isExisting
		? __( 'We’ve detected your existing Solid Central site. It’s time to log in to your SolidWP account to complete the server connection process.', 'it-l10n-solid-backups' )
		: __( 'We’ve started the process of connecting to your site. It’s time to log in to your SolidWP account to complete the site connection process.', 'it-l10n-solid-backups' );
	const actionText = isExisting
		? __( 'Continue server connection', 'it-l10n-solid-backups' )
		: __( 'Complete site connection', 'it-l10n-solid-backups' );

	return (
		<StyledPageContainer variant={ SurfaceVariant.PRIMARY }>
			<StyledContent direction="column" align="center" justify="center" gap={ 10 }>
				<Flex direction="column" align="center" justify="center" gap={ 4 } expanded={ false }>
					<Heading
						level={ 2 }
						size={ TextSize.GIGANTIC }
						weight={ TextWeight.NORMAL }
						text={ __( 'You’re doing great, we’re almost there!', 'it-l10n-solid-backups' ) }
					/>
					<Text
						as="p"
						align="center"
						variant={ TextVariant.MUTED }
						size={ TextSize.LARGE }
						text={ bodyText }
					/>
				</Flex>
				{ isExpired && (
					<MessageList type="danger" messages={ [ __( 'The connection attempt has expired. Please refresh and try connecting again.', 'it-l10n-solid-backups' ) ] } />
				) }
				<StyledContinue
					variant="primary"
					icon={ arrowRight }
					iconPosition="right"
					href={ connectLink }
					text={ actionText }
					disabled={ isExpired }
					rel="noreferrer"
				/>
			</StyledContent>
			<Gears />
		</StyledPageContainer>
	);
}
