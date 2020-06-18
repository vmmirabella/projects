# Design Patterns Used

 ## 1. Abstract Factory
* Game
   * Client
* CardGameProducer
  * Used by Game to instantiate a card game factory
* CardGameFactory
  * Abstract factory
* CrazyEightsFactory, GoFishFactory, …
    * Concrete factories
* Player, Rules
    * Abstract products
* CrazyEightsPlayer, CrazyEightsRules, …
    * Concrete products

### Purpose
Groups the methods for creating related objects into families, where each family represents a particular card game. The factory is selected when a Game is initialized. This allows the Game to simply call generic methods (makeHuman, makeRules, etc.) instead of game-specific ones, meaning that when they want to start a different game, only the instantiation code needs to be changed.

 ## 2. Factory Method

* CardGameFactory
    * Creator that contains factory methods
* CrazyEightsFactory, GoFishFactory, …
    * Concrete creators that implement factory methods
* Player, Rules
    * Abstract products
* CrazyEightsPlayer,CrazyEightsRules, …
    * Concrete products

### Purpose
Used in implementing the Abstract Factory pattern. CardGameFactory is an interface containing factory methods for creating objects to be used in the game, while actual creation is deferred to the concrete creators who instantiate the game-specific objects. This leads to the benefits provided by the Abstract Factory pattern used.

## 3. Strategy

* Game (e.g. CrazyEightsGame)
    * Context
* ScoringStrategy
    * Strategy interface for scoring
* CrazyEightsScoring, GoFishScoring, …
    * Concrete strategies

### Purpose
The ScoringStrategy interface defines a family of scoring algorithms that are interchangeable depending on what game is being played. The strategy being used is stored in the game and selected when the game is initialized, e.g. a GoFishFactory will set the strategy to GoFishScoring. This allows us to use the same generic calScore method to calculate a player’s score regardless of what game is being played. It also means that alternative scoring schemes for a game can be easily added.

 ## 4. Template Method
Classes Involved
* Game
    * Abstract class containing a template method
* CrazyEightsGame,GoFishGame, …
    *Concrete classes that implement varying behaviour within the template method

### Purpose
The template method used is a generic playGame method that follows the same structure for all card games: initializing the game and looping the player turns until a win condition is met. This pattern is used because some parts of the algorithm are the same between games (e.g. obtaining number of players) while others are different (e.g. dealing cards, structure of player turns). This is beneficial to the program because it avoids code duplication for the parts that are the same.
