import styled from '@emotion/styled';
import { Surface } from '@ithemes/ui';
import { BackupsLogoBlack } from '../../../images';

const StyledFooter = styled( Surface )`
	display: flex;
	justify-content: center;
	padding: 50px 0;
	
	@media screen and (min-width: ${ ( { theme } ) => theme.breaks.large }px) {
		padding: 100px 0;
	}
`;

const StyledLogo = styled( BackupsLogoBlack )`
	max-width: 215px;
`;

export default function WelcomeFooter() {
	return (
		<StyledFooter as="footer">
			<a href="https://go.solidwp.com/get-backups-nextgen" target="_blank" rel="noreferrer">
				<StyledLogo />
			</a>
		</StyledFooter>
	);
}
