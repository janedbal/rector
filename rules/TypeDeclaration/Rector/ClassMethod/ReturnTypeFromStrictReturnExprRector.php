<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Yield_;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Return_;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\ValueObject\PhpVersion;
use Rector\TypeDeclaration\TypeAnalyzer\AlwaysStrictBoolExprAnalyzer;
use Rector\VersionBonding\Contract\MinPhpVersionInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Tests\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictReturnExprRector\ReturnTypeFromStrictReturnExprRectorTest
 */
final class ReturnTypeFromStrictReturnExprRector extends AbstractRector implements MinPhpVersionInterface
{
    /**
     * @readonly
     * @var \Rector\TypeDeclaration\TypeAnalyzer\AlwaysStrictBoolExprAnalyzer
     */
    private $alwaysStrictBoolExprAnalyzer;
    public function __construct(AlwaysStrictBoolExprAnalyzer $alwaysStrictBoolExprAnalyzer)
    {
        $this->alwaysStrictBoolExprAnalyzer = $alwaysStrictBoolExprAnalyzer;
    }
    public function getRuleDefinition() : RuleDefinition
    {
        return new RuleDefinition('Add strict return type based on returned strict expr type', [new CodeSample(<<<'CODE_SAMPLE'
final class SomeClass
{
    public function run()
    {
        return $this->first() && $this->somethingElse();
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass
{
    public function run(): bool
    {
        return $this->first() && $this->somethingElse();
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(Node $node) : ?Node
    {
        if ($node->returnType !== null) {
            return null;
        }
        if (!$this->hasSingleStrictReturn($node)) {
            return null;
        }
        $node->returnType = new Identifier('bool');
        return $node;
    }
    public function provideMinPhpVersion() : int
    {
        return PhpVersion::PHP_74;
    }
    private function hasSingleStrictReturn(ClassMethod $classMethod) : bool
    {
        if ($classMethod->stmts === null) {
            return \false;
        }
        if ($this->betterNodeFinder->hasInstancesOfInFunctionLikeScoped($classMethod, [Yield_::class])) {
            return \false;
        }
        $returns = $this->betterNodeFinder->findInstancesOfInFunctionLikeScoped($classMethod, Return_::class);
        if (\count($returns) !== 1) {
            return \false;
        }
        foreach ($classMethod->stmts as $stmt) {
            if (!$stmt instanceof Return_) {
                continue;
            }
            // we need exact expr return
            if (!$stmt->expr instanceof Expr) {
                return \false;
            }
            if ($this->alwaysStrictBoolExprAnalyzer->isStrictBoolExpr($stmt->expr)) {
                return \true;
            }
        }
        return \false;
    }
}