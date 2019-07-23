# kazoonBot

## 使い方

1. @kazoonBot をフォロー&固定ツイートを RT してもらう
2. ユーザーが「Retweet List」に登録される
3. Retweet List のメンバーが「みみぺん」を含むツイートをすると、
   Bot がリツイートする
4. @kazoonBot がアンフォローされたら、「Retweet List」からもオサラバ

## (備忘録)固定ツイートの文言を差し替える時

1. GET statuses/retweeters/ids のログを保存し、リツイートメンバー全員の
   ID をとっておく
2. 固定ツイートを消す
3. 新しい固定ツイートをする
4. ソースコード内の GET statuses/retweeters/ids の id 値を更新する
