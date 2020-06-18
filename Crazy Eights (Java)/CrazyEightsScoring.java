package btp600.A2;

import java.util.List;
/**
 * Scoring Strategy used in CrazyEights. Extends ScoringStrategy which only has calScore method to be implemented.
 * Value of remaining cards:
 * Eight = 50 points
 * King(13), Queen(12), Jack(11) or 10 = 10 points
 * Ace = 1 point
 * Other cards = value based on rank (ie. 5 of Hearts = 5 points)
 */
public class CrazyEightsScoring extends ScoringStrategy{

    /*CalScore will calculate the score of the winning player. The winning player in crazy eights
    * will the be player whom has an empty hand. The winning player collects points based on the value of
    * cards remaining in the other player's hands. A list of players is passed in as a parameter and the
    * winning player's points will be set after all the points, from each player, have been tallied.
    */
    @Override
    public void calScore(List<Player> sPlayers) {

        int points =0;
        int winner =0;

        for(int i=0; i<sPlayers.size(); i++)
        {
            if(sPlayers.get(i).hand.isEmpty())
                winner = i;
            else {
                for (int j = 0; j < sPlayers.get(i).hand.getNumCards(); j++) {
                    Card c = sPlayers.get(i).hand.getCard(j);

                   switch (c.getRank())
                   {
                       case 8:
                           points+=50;
                           break;
                       case 10:
                       case 11:
                       case 12:
                       case 13:
                           points+=10;
                           break;
                       default:
                           points+=c.getRank();
                           break;
                   }//end of switch
                }//end of else for loop
              }//end of else
        }//end of outer for loop

        sPlayers.get(winner).setPoints(points);
    }
}
