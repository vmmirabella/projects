package btp600.a3.vmmirabella;

/**
 * Abstract class for player, containing common methods that will be used for every type of player, across all games and types (human/computer)
 * Each player will contain a name, hand->holds cards they can play and points->determines their score for the game.
 */
public abstract class Player {
    private String name;
    protected Hand hand; //// FIXME: 4/2/2016 changed to protected from private
    private int points;

    //base constructor
    public Player(){
        name = null;
        points = 0;
    }
    // Constructor, takes player name
    public Player(String n) {
        name = n;
        points=0;
        hand = new Hand();
    }

    // Getter for player name
    public String getName() {
        return name;
    }

    //checks if a player's hand is empty
    public boolean hasEmptyHand() {
        return hand.isEmpty();
    }

    //Displays contents of hand to player
    public void printHand() {
        System.out.println("Your hand is: " + hand);
    }

    // Sorts cards in hand
    public void sortHand() {
        hand.sort();
    }

    // Add a card to hand
    public void addCard(Card c) {
        hand.insertCard(c);
    }

    // Draw a card from a deck (removes card from deck)
    public void drawCard(Deck d) {
        hand.insertCard(d.drawCard());
    }

    //Removes a card from hand, returns card
    public Card playCard(Card c) {
        return hand.removeCard(c);
    }

    //Check if a certain card is in hand, plays card if so, otherwise returns null
    public Card hasCard(Card c) {
        if (hand.searchCard(c)) {
            return c;
        }
        return null;
    }

    //Sets the points of a player
    public void setPoints(int p){ this.points=p;}

    //retrievers the current points total the player has accumulated
    public int getPoints () {return points;}

    //Each specific game will implement how their player/computer will/if they are able to play a card
    public abstract boolean takeTurn(Rules r, Deck d, Pile p);//// TODO: 4/12/2016 changed
}
